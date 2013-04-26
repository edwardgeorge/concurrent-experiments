<?php

class storage extends Stackable {
    public function run(){}
}

class myAsync extends Thread {
    public function __construct($storage, $num1, $num2, $operation=NULL) {
        $this->storage = $storage;
		$this->num1 = $num1;
		$this->num2 = $num2;
		$this->op = $operation;
    }

    public function run(){
	  switch ($this->op){
        case 'add':
		  $this->storage[] = $res = $this->num1 + $this->num2;
		break;
        default:
          $this->storage[] = $res = $this->num1 * $this->num2;
        break;
      }
    } 
}

$storage = new storage();

$myAsync1 = new myAsync($storage, 2, 10);
$myAsync1->start();

$myAsync2 = new myAsync($storage, 2, 20);
$myAsync2->start();

$myAsync3 = new myAsync($storage, 30, 40, "add");
$myAsync3->start();

if ($myAsync1->join() && $myAsync2->join() && $myAsync3->join()){
	
	$result = 0;
	$string = "";

	foreach($storage as $value){
		$result += $value;
		$string .= $value . " + ";
	}

	print substr($string, 0, -3) . " = ".$result;
}









  
?>