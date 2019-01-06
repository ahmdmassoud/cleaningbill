<?php 
require_once("MysqliDb.php");
class customers
{
	public $customerId;
	public $name;
	public $address; 
	public $post;
	public $city; 
	public $billPayer;
	public $billPayerName; 
	public $billPayeraddress; 
	public $billPayerpost;
	public $billPayercity; 
	public $billPayerId; 

	public function createCustomer ($db, $name,$address, $post, $city, $billPayer,$billPayerName=null, $billPayeraddress=null, $billPayerpost=null, $billPayercity=null){
		$this->name= $name; 
		$this->address= $address;
		$this->post= $post; 
		$this->city= $city;
		$this->billPayer= $billPayer; 
		$data = Array ("name" => $this->name,"address"=>$this->address,"post"=>$this->post,"city"=>$this->city,"billPayer"=>$this->billPayer );
		$id = $db->insert ('customers', $data);
		$this->customerId=$id;
		if($id) $this->message = "customer was added Successfully";

		if ($billPayer == 0) {
			$this->billPayerName= $billPayerName; 
			$this->billPayeraddress= $billPayeraddress; 
			$this->billPayerpost= $billPayerpost; 
			$this->billPayercity= $billPayercity; 
			$data = Array ("billerName" => $this->billPayerName,"billerAddress"=>$this->billPayeraddress,"billerPost"=>$this->billPayerpost,"billerCity"=>$this->billPayercity, "customerId"=>$this->customerId);
			$id = $db->insert ('billPayers', $data);
			$this->billPayerId=$id;
			if($id) $this->message = "billPayerId was added Successfully";
			

		}

	}
	public function deleteCustomer ($db, $customerId){
		$db->where('id', $this->customerId);
		if($db->delete('customers')) $this->message = "bill was deleted";
		if ($this->billPayer == 0) {
			$db->where('id', $this->billPayerId);
			if($db->delete('billPayers')) $this->message = "billPayer was deleted";
		}
		if ($customerId == $this->customerId) {
			$this->customerId= null;
			$this->name= null; 
			$this->address= null; 
			$this->post= null; 
			$this->city= null; 		
			$this->billPayer=null;
			$this->billPayerName= null; 
			$this->billPayeraddress= null; 
			$this->billPayerpost= null; 
			$this->billPayercity= null; 		
			$this->billPayerId=null;			
		}

	}

	public function updateCustomer ($db,$customerId, $name,$address, $post, $city, $billPayer,$billPayerId, $billPayerName=null, $billPayeraddress=null, $billPayerpost=null, $billPayercity=null){
		$data = Array ("id" => $customerId,"name"=>$name, "address"=>$address, "post"=>$post, "city"=>$city,"billPayer"=>$billPayer);
		$db->where ('id', $customerId);
		if ($db->update ('customers', $data)){
			$this->message = " customer was updated Successfully";	
			if ($billPayer == 0) {
			$this->billPayerName= $billPayerName; 
			$this->billPayeraddress= $billPayeraddress; 
			$this->billPayerpost= $billPayerpost; 
			$this->billPayercity= $billPayercity; 
			$data = Array ("id"=> $this->billPayerId, "billerName" => $this->billPayerName,"billerAddress"=>$this->billPayeraddress,"billerPost"=>$this->billPayerpost,"billerCity"=>$this->billPayercity,"customerId" =>$customerId);
			$db->where ('id', $billPayerId);
			if ($db->update ('billPayers', $data)) $this->message = " billPayers was updated Successfully";			

		}

		} 

		else 
			$this->message = "update failed: " . $db->getLastError();


	}

	/**
      * This method gets a customer by one of the attributes you decide and sets the object.
      *
      * @param string $what A text could be id, name, address etc...
      * @param string $value A text contain the corrosponding value of $what.
      * @return nothing
      */

	public function getCustomerBy($db,$what, $value){
		$db->where ($what, $value);
		$customer = $db->getOne ("customers");
		$this->customerId = $customer["id"];
		$this->name = $customer["name"];
		$this->address = $customer["address"];
		$this->post = $customer["post"];
		$this->city = $customer["city"];
		$this->billPayer = $customer["billPayer"];
		if ($customer["billPayer"] ==0) {
			$db->where ("customerId", $customer['id']);
			$billPayer = $db->getOne ("billPayers");	
			$this->billPayerName = $billPayer["billerName"];
			$this->billPayeraddress = $billPayer["billerAddress"];
			$this->billPayerpost = $billPayer["billerPost"];
			$this->billPayercity = $billPayer["billerCity"];
			$this->billPayerId = $billPayer["id"];
		}

	}


}
?> 