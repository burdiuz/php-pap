<?php

/**
 * 
 * @author iFrame
 *
$config = DataGroupXMLConverter::convert('<states><state><name>active</name><tick>50</tick><timeout>5</timeout><enableEvents>1</enableEvents><calculateLoad>1</calculateLoad></state><state><name>inactive</name><tick>100</tick><timeout>10</timeout></state><state><name>sleep</name><tick>250</tick><timeout>0</timeout></state></states>');
/** @var WorkingCycle * /
$cycle = new WorkingCycle(new FunctionHandler('tick'), null, $config);
print_r($cycle);
echo "<br>\r\n";
/** @var WorkingCycle * /
$child = null;
/** @var int * /
$index = 0;
function tick(){
	global $cycle, $child;
	echo 'root tick '.$cycle->currentState()->name().' '.time()."<br>\r\n";
	if(!$child){
		$child = $cycle->createChild(new FunctionHandler('childTick'), null, $cycle->states());
		$child->start();
	}
}
function childTick(){
	global $child, $index;
	echo 'leaf tick '.$child->currentState()->name().' '.time()."<br>\r\n"; 
	$index++;
	if($index>100){
		$child->stop();
	}
}
$cycle->start();
exit;
 */
class WorkingCycle extends EventDispatcher implements IWorkingCycle, IWorkingCycleChain{
	static private $_chain = array();
	/**
	 * Is cycle initialized
	 * @var boolean
	 */
	protected $_initialized;
	/**
	 * Tick handler
	 * @var IHandler
	 */
	protected $_handler;
	/**
	 * Main Config
	 * @var IDataGroup
	 */
	protected $_config;
	/**
	 * Is working cycle started.
	 * @var boolean
	 */
	private $_started;
	/**
	 * Was states defined
	 * @var boolean
	 */
	private $_statesAllowed;
	/**
	 * Available states for this working cycle
	 * @var IWorkingCycleStatesList
	 */
	private $_states;
	private $_lastActivity;
	/**
	 * Current working cycle state
	 * @var WorkingCycleStateInternals
	 */
	private $_currentState;
	/**
	 * Calculated tick execution load
	 * @var number
	 */
	private $_calculatedLoad = 0;
	public function __construct(IHandler $handler=null, IEventDispatcher $target=null, IDataGroup $config=null){
		if($config){
			$this->_config = $config;
			$this->presetStates($handler, $target);
		}else if($handler){
			$this->initialize($handler, $target);
		}
	}
	private function presetStates(IHandler $handler, IEventDispatcher $target=null){
		$states = null;
		$this->initialize($handler, $target, WorkingCycleStateList::get($this->_config));
	}
	public function initialize(IHandler $handler, IEventDispatcher $target=null, WorkingCycleStateList $states=null){
		if($this->_initialized) throw new Exception('WorkingCycle Error: Already initialized.');
		$this->_handler = $handler;
		if($target) $this->setEventTarget($target);
		$this->_statesAllowed = (boolean)$states || !$states->count();
		$this->_states = $this->_statesAllowed ? $states : WorkingCycleStateList::getDefault();
		$this->resetState();
		$this->_initialized = true;
	}
	public function start(){
		$this->_started = true;
		array_push(self::$_chain, $this);
		$this->workingCycle();
		$this->_started = false;
	}
	public function stop(){
		if($this->isStarted() && !$this->hasChild()){
			$this->_started = false;
			array_pop(self::$_chain);
		}else{
			throw new Exception('WorkingCycle Error: Instance in a middle of the chain can not be stopped.');
		}
	}
	private function workingCycle(){
		while($this->_started){
			$time = microtime(true);
			$active = false;
		//	try{
				if($this->_currentState->enableEvents) $this->dispatchEvent(new WorkingCycleEvent(WorkingCycleEvent::TICK_ENTER, $this->_states->current()));
				$active = $this->_handler->apply();
				if($this->_currentState->enableEvents) $this->dispatchEvent(new WorkingCycleEvent(WorkingCycleEvent::TICK_EXIT, $this->_states->current()));
				$tickTime = ($this->_currentState->tick-(microtime(true)-$time)*1000);
				if($this->_currentState->calculateLoad){
					$this->_calculatedLoad = $tickTime/$this->_currentState->tick;
				}
				if($this->_statesAllowed){
					$this->calculateTimeout($active);
					$tickTime = ($this->_currentState->tick-(microtime(true)-$time)*1000);
				}
		/*
			}catch(Exception $error){
				return;
			}
		*/
			usleep($tickTime);
		}
	}
	private function calculateTimeout($active){
		if($active){
			if($this->_currentStateIndex>0){
				$this->_states->reset();
				$this->resetState();
			}
		}else if($this->_currentState->timeout && $this->_states->currentIndex()<$this->_states->lastIndex()){
			$time = microtime(true)-$this->_lastActivity;
			if($time>=$this->_currentState->timeout){
				$this->_states->next();
				$this->resetState();
			}
		}
	}
	private function resetState(){
		$this->_currentState = $this->_states->current()->getInternal();
		if($this->_states->lastIndex()<=$this->_states->currentIndex()){
			$this->_currentState->timeout = 0;
		}
		$this->_lastActivity = microtime(true);
		$this->dispatchEvent(new WorkingCycleEvent(WorkingCycleEvent::STATE_CHANGED, false, $this->_states->current()));
	}
	public function isInitialized(){
		return $this->_initialized;
	}
	public function isStarted(){
		return $this->_started;
	}
	public function isStatesAllowed(){
		return $this->_statesAllowed;
	}
	public function states(){
		return $this->_states;
	}
	public function target(){
		return $this->getEventTarget();
	}
	public function chain(){
		return $this->_started ? $this : null;
	}
	public function currentState(){
		return $this->_states->current();
	}
	public function currentStateIndex(){
		return $this->_states->currentIndex();
	}
	public function getCalculatedLoad(){
		return $this->_currentState->calculateLoad ? $this->_calculatedLoad : false;
	}
	public function hasParent(){
		$index = array_search($this, self::$_chain, true);
		return is_int($index) && $index>0;
	}
	public function getParent(){
		$parent = null;
		if($this->hasParent()){
			$index = array_search($this, self::$_chain, true);
			$parent = self::$_chain[$index-1];
		}else{
			throw new Exception('WorkingCycle Error: Parent does not exists.');
		}
		return $parent;
	}
	public function hasChild(){
		$index = array_search($this, self::$_chain, true);
		return is_int($index) && $index<count(self::$_chain)-1;
	}
	public function getChild(){
		$child = null;
		if($this->hasChild()){
			$index = array_search($this, self::$_chain, true);
			$child = self::$_chain[$index+1];
		}else{
			throw new Exception('WorkingCycle Error: Child does not exists.');
		}
		return $child;
	}
	public function createChild(IHandler $handler, IEventDispatcher $target=null, IWorkingCycleStateList $states=null){
		/** @var IWorkingCycle */
		$cycle = null;
		if($this->isInitialized() && !$this->hasChild()){
			$cycle = new WorkingCycle();
			$cycle->initialize($handler, $target, $states);
		}else{
			throw new Exception('WorkingCycle Error: Child creation prohibited.');
		}
		return $cycle;
	}
	public function getFirst(){
		return isset(self::$_chain[0]) ? self::$_chain[0] : false;
	}
	public function getAt($index){
		return isset(self::$_chain[(int)$index]) ? self::$_chain[(int)$index] : false;
	}
	public function count(){
		return count(self::$_chain);
	}
	public function getLast(){
		return $this->count()>0 ?  self::$_chain[count(self::$_chain)-1] : false;
	}
}
?>