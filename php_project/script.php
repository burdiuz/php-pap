<?php
namespace a{
	class class1{
		public function test(){
			echo 'class1';
		}
	}
}
namespace b{
	class class2 extends \a\class1{
		public function test(){
			echo 'class2';
		}
	}
}
?>