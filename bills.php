<?php 
require_once("MysqliDb.php");
class bills 
{
	public $customerId;
	public $billId;
	public $dates; 
	
	public function createBill ($db, $customerId, $dates){
		$this->customerId= $customerId;
		$this->dates= $dates; 
		$data = Array ("customerId" => $this->customerId,"dates"=>$this->dates);
		$id = $db->insert ('bills', $data);
		$this->billId=$id;
		if($id) $this->message = "bill was added Successfully";


	}
	public function deleteBill ($db, $billId){
		$db->where('id', $this->billId);
		if($db->delete('bills')) $this->message = "bill was deleted";
		if ($billId == $this->billId) {
			$this->billId= null;
			$this->dates= null; 
			$this->customerId= null; 
		}

	}

	public function updateBill ($db, $customerId, $dates, $billId){
		$data = Array ("customerId" => $customerId,"dates"=>$dates);
		$db->where ('id', $billId);
		if ($db->update ('bills', $data)){
			$this->message = " bill was updated Successfully";			
		} 

		else 
			$this->message = "update failed: " . $db->getLastError();


	}

	/**
      * This method gets all the bills by one of the attributes you decide.
      *
      * @param string $what A text could be id, customerId, dates etc...
      * @param string $value A text contain the corrosponding value of $what.
      * @return array of all bills.
      */

	public function getBillBy($db,$what, $value){
		$db->where ($what, $value);
		$bill = $db->get("bills");
		return $bill;
	}


}


?> 