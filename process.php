<?php 
require_once("MysqliDb.php");
require_once("bills.php");
require_once("customers.php");
require_once("tasks.php");
$customer = new customers();
$bills = new bills();
$tasks = new tasks();
if (isset($_POST["createUser"])) {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $post = $_POST["post"];
    $billerPayer = $_POST["billPayer"];
    $billerName = $_POST["billerName"];
    $billerAddress = $_POST["billerAddress"];
    $billerCity = $_POST["billerCity"];
    $billerPost = $_POST["billerPost"];
    $customer->createCustomer($db, $name,$address, $post, $city, $billerPayer,$billerName, $billerAddress, $billerPost, $billerCity);
    redirectTo('index.php');
    
}
elseif (isset($_POST["createBill"])) {
    $customerName = $_POST["customerName"];
    $taskName[0] = $_POST["taskName"];
    $dates[0] = $_POST["dates"];
    $amount[0] = $_POST["amount"];
    $unit[0] = $_POST["unit"];
    $unitPrice[0] = $_POST["unitPrice"];
    $taxPercentage[0] = $_POST["taxPercentage"];
    $noTasks = $_POST["noTasks"];
    $customer->getCustomerBy($db,"name",$customerName);
    $bills->createBill($db, $customer->customerId, date("d.m.Y"));
    if ($noTasks > 1) {
        for ($i=1; $i < $noTasks; $i++) { 
            $taskName[$i] = $_POST["taskName".$i];
            $dates[$i] = $_POST["dates".$i];
            $amount[$i] = $_POST["amount".$i];
            $unit[$i] = $_POST["unit".$i];
            $unitPrice[$i] = $_POST["unitPrice".$i];
            $taxPercentage[$i] = $_POST["taxPercentage".$i];
    
        }
    }

    for ($x=0; $x < $noTasks ; $x++) { 
       $tasks->createTasks ($db, $taskName[$x], $dates[$x], $unit[$x], $unitPrice[$x], $amount[$x], $taxPercentage[$x], $bills->billId );
    }
    if ($_POST["lang"] == "SWE") {
      redirectTo("yourbill.php?billId=$bills->billId");
    }
    else {
      redirectTo("yourbill-FI.php?billId=$bills->billId");
    }
}
else {
       redirectTo("index.php"); 
    }

function redirectTo($page){
    header("Location: {$page}");
}


?>