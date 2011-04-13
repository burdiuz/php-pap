<?php

class DataLevels extends ArrayObject implements IDataLevels{
	const SINGLE_LEVEL_ERROR = 'DataLevels Error: IDataGroup methods allowed only with single level instances.';
	public function __construct(IDataContainer $container){
		parent::__construct();
		if($container){
			$this->offsetSet(0, $container);
		}
	}
	private function checkDataMethods(){
		if(!$this->isSingleLevel()){
			throw new Exception(self::SINGLE_LEVEL_ERROR);
		}
	}
	/* (non-PHPdoc)
	 * @see IDataContainer::value()
	 */
	public function value($name, $default=null){
		$this->checkDataMethods();
		return parent::offsetGet(0)->value($name, $default);
	}
	/* (non-PHPdoc)
	 * @see IDataContainer::hasValue()
	 */
	public function hasValue($name){
		$this->checkDataMethods();
		return parent::offsetGet(0)->hasValue($name);
	}
	/* (non-PHPdoc)
	 * @see IDataContainer::dataManager()
	 */
	public function dataManager(){
		$this->checkDataMethods();
		return parent::offsetGet(0)->dataManager();
	}
	/* (non-PHPdoc)
	 * @see IDataContainer::dataIterator()
	 */
	public function dataIterator(){
		$this->checkDataMethods();
		return parent::offsetGet(0)->dataIterator();
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::values()
	 */
	public function values(){
		$this->checkDataMethods();
		return parent::offsetGet(0)->values();
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::hasGroup()
	 */
	public function hasGroup($name){
		$this->checkDataMethods();
		return parent::offsetGet(0)->hasGroup($name);
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::group()
	 */
	public function group($name){
		$this->checkDataMethods();
		return parent::offsetGet(0)->group($name);
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::groupManager()
	 */
	public function groupManager(){
		$this->checkDataMethods();
		return parent::offsetGet(0)->groupManager();
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::groupsIterator()
	 */
	public function groupsIterator(){
		$this->checkDataMethods();
		return parent::offsetGet(0)->groupsIterator();
	}
	/* (non-PHPdoc)
	 * @see IDataGroup::groupByValue()
	 */
	public function groupByValue($name, $value){
		$this->checkDataMethods();
		return parent::offsetGet(0)->groupByValue($name, $value);
	}
	public function offsetExists($index){
		return parent::offsetExists(self::validateIndex($index));
	}
	public function offsetGet($index){
		return parent::offsetGet(self::validateIndex($index));
	}
	private function checkValueType($value){
		if(!($value instanceof IDataContainer)){
			$name = 'non object';
			if(is_object($value)){
				$reflection = new ReflectionObject($value);
				$name = $reflection->getName();
			}
			throw new Exception('DataLevels Error: Only IDataContainer values are allowed, "'.$name.'" passed.');
		}
	}
	/* (non-PHPdoc)
	 * @see ArrayObject::offsetSet()
	 */
	public function offsetSet($index, $value){
		$this->checkValueType($value);
		parent::offsetSet(self::validateIndex($index), $value);
	}
	public function append($value){
		$this->checkValueType($value);
		parent::offsetSet(null, $value);
	}
	public function offsetUnset($index){
		parent::offsetUnset(self::validateIndex($index));
	}
	/* (non-PHPdoc)
	 * @see IDataLevels::count()
	 */
	public function count(){
		return parent::count();
	}
	/* (non-PHPdoc)
	 * @see IDataLevels::hasLevels()
	 */
	public function hasLevels(){
		return (boolean)$this->count();
	}
	/* (non-PHPdoc)
	 * @see IDataLevels::isSingleLevel()
	 */
	public function isSingleLevel(){
		return $this->count()==1;
	}
	/* (non-PHPdoc)
	 * @see IDataLevels::level()
	 */
	public function level($index){
		return $this[$index];
	}
	/* (non-PHPdoc)
	 * @see IDataLevels::levelsManager()
	 */
	public function levelsManager(){
		return new DataLevelsManager($this);
	}
	/* (non-PHPdoc)
	 * @see IDataLevels::levelByValue()
	 */
	public function levelByValue($name, $value){
		foreach($this as /** @var IDataContainer */$level){
			if($level->hasValue($name) && $level->value($name)==$value){
				return $level;
			}
		}
		return null;
	}
	/* (non-PHPdoc)
	 * @see IDataLevels::levelsIterator()
	 */
	public function levelsIterator(){
		return $this->getIterator();
	}
	static public function validateIndex($index){
		return max(0, (int)$index);
	}
}

?>