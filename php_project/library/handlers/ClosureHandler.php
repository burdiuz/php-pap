<?php

class ClosureHandler extends MethodHandler {
	const CLOSURE_METHOD = '__invoke';
	public function __construct($target){
		if(method_exists($target, self::CLOSURE_METHOD)){
			parent::__construct($target, self::CLOSURE_METHOD);
		}else{
			throw new Exception('ClosureHandler Error: Closure must implement "'.self::CLOSURE_METHOD.'" method.');
		}
	}
}

?>