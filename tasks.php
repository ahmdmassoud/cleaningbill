<?php 
require_once("MysqliDb.php");
class tasks 
{
	public $billId;
	public $taskId;
	public $name; 
	public $dates; 
	public $unit; 
	public $unitPrice;
	public $count; 
	public $vat; 
	public $message;


	public function createTasks ($db, $name, $dates, $unit, $unitPrice, $count, $vat, $billId ){
		$this->billId= $billId;
		$this->name= $name; 
		$this->dates= $dates; 
		$this->unit= $unit; 
		$this->unitPrice= $unitPrice; 
		$this->count= $count; 
		$this->vat= $vat;
		$data = Array ("billid" => $this->billId,
               "taskName" => $this->name,
               "unit" => $this->unit,
               "unitPrice"=>$this->unitPrice,
               "amount"=>$this->count,
               "taxPercentage"=>$this->vat,
               "dates"=>$this->dates);
		$id = $db->insert ('tasks', $data);
		$this->taskId=$id;
		if($id) $this->message = "Task was added Successfully";


	}
	public function deleteTask ($db, $taskId){
		$db->where('id', $this->taskId);
		if($db->delete('tasks')) $this->message = "Task was deleted";
		if ($taskId == $this->taskId) {
			$this->taskId= null;
			$this->billId= null;
			$this->name= null; 
			$this->dates= null; 
			$this->unit= null; 
			$this->unitPrice= null; 
			$this->count= null; 
			$this->vat= null;
		}

	}

	public function updateTask ($db, $taskId, $name, $dates, $unit, $unitPrice, $count, $vat, $billId){
		$data = Array ("billid" => $billId,
               "taskName" => $name,
               "unit" => $unit,
               "unitPrice"=>$unitPrice,
               "amount"=>$count,
               "taxPercentage"=>$vat,
               "dates"=>$dates);
		$db->where ('id', $taskId);
		
		if ($db->update ('tasks', $data)){
			$this->message = " Task was updated Successfully";			
		} 

		else 
			$this->message = "update failed: " . $db->getLastError();


	}

		/**
      * This method gets a task by one of the attributes you decide and sets the object.
      *
      * @param string $what A text could be id, date, unit etc...
      * @param string $value A text contain the corrosponding value of $what.
      * @return nothing
      */

	public function getTaskBy($db,$what, $value){
		$db->where ($what, $value);
		$task = $db->getOne ("tasks");
		$this->name=$task["taskName"];
		$this->billId = $task["billid"];
		$this->taskId = $task["id"];
		$this->dates = $task["dates"];
		$this->unit = $task["unit"];
		$this->unitPrice = $task["unitPrice"];
		$this->count = $task["amount"];
		$this->vat = $task["taxPercentage"];

		
	}


}

?> 