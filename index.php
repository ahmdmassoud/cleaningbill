<?php 
  require_once("MysqliDb.php");
  require_once("bills.php");
  require_once("customers.php");
  require_once("tasks.php");
  $customer = new customers();
?>
<!DOCTYPE html>
<html>
  <head>
  <title>Cleaning biller</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
  </head>
  <style>
    * {
      box-sizing: border-box
    }
    body {
      margin: 0px
    }
    .halfscreen {
      width: 50%;
      height: 100vh;
      float: left;
      padding: 20px;
      padding-top: 0px
    }
    .titles {
    }
    table {
      border-collapse: collapse;
      width: 100%;
      background-color: #ffffff;
    }
    tr {background-color: #ffffff}
    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }
    .selected {
      background-color: #65a3e2;
      cursor: auto;
    }
    .button {
      background-color: #ECECEC;
      border: 1px solid #2C2C74;
      border-radius: 2px;
      fontsize:25px;
      padding: 10px 15px;
      width: 120px;
      cursor: pointer;
      margin: 10px
    }
    .button:hover {
      background-color: #e5e5e5;
    }
    .button:active {
      background-color: #a0a0a0;
    }
    #custinp {
      border: none;
      background: none;
      color: black;
      font-weight: bold
    }
    p {
      display:inline-block;
      margin:5px
    }
    input {
      width: 100px
    }
    input[type = "number"] {
      width: 50px;
    } 
    input[type = "date"] {
      width: 150px;
    }
    .custitem {
      padding:10px;
      cursor:pointer
    }
    .custitem:hover {
      background-color: #e5e5e5;
    }
    .custitem.picked {
      background-color: #5599d5;
      color: #FAFAFA
    }
    input[type = "text"].addedtask {
      width: 50px;
    }    
  </style>
  <body id="hid">
    <div style="background-color:#EFF1F3">
      <div style="float:left"><img src="logo.png" style="height:150px;" /></div>
      <h1 style="font-size:50px;margin:0;padding:50px">Räkningslagningsprogram</h1>
    </div>
    <div class="halfscreen" style="background-color:#EFF1F3;clear:left">
      <h2 class="titles">Kunder</h2>
      <div style="border: 2px solid #0a0500;overflow:auto;height:200px">
        <?php
          $customers = $db->get('customers');
          for ($i=0; $i <count($customers) ; $i++) { 
            echo"<div class=\"custitem\">{$customers[$i]['name']}</div>";
          }
        ?>
      </div>
      <div class="button" id="addshower">+Lägg till</div>
      <div id="custAdder" hidden>
        <div style="margin-top:20px;border: 1px solid #242424;background-color:#ffffff;padding:10px">
          <form method="POST" action="process.php">
          <p>Namn</p><input type=text name="name" required></input><br/>
          <p>Adress</p><input type=text name="address" required></input><br/>
          <p>Kommun</p><input type=text name="city" required></input><br/>
          <p>Postnummer</p><input type=text name="post" required></input><br/>
          <p>Betalar själv</p>
            Ja<input type=radio name=billPayer value=1 checked onClick="payerthing()"/>
            Nej<input type=radio name=billPayer value=0   onClick="nopayerthing()"/><br/>
          <div id="betalare" hidden>
          <p>Betalarens namn</p><input type=text name="billerName" ></input><br/>
          <p>Betalarens adress</p><input type=text name="billerAddress"></input><br/>
          <p>Betalarens kommun</p><input type=text name="billerCity"></input><br/>
          <p>Betalarens postnummer</p><input type=text name="billerPost"></input><br/>
          </div>
          <p>Lägg till</p><input type=submit id="submit" name="createUser"></input><br/>
        </form>
        </div>
      </div>
      <h2 class="titles">Tidigare räkningar</h2>
      <div style="border: 2px solid #0a0500;overflow:auto;height:200px">
        <table>
        <?php
          $bills = $db->get('bills');
          
          for ($i=0; $i <count($bills) ; $i++) {         
            $customer->getCustomerBy($db,"id", $bills[$i]['customerId']);
            echo"<tr class=\"billitem\"><td>{$bills[$i]['id']}</td><td>{$bills[$i]['dates']}</td><td>{$customer->name}</td></tr>";
          }
        ?>
        </table>
      </div>
    </div>
  <form method="POST" action="process.php"> 
    <div class="halfscreen" style="background-color:#EFF1F3">
      <h2 class="titles">Räkning</h2>
      Räkning for: <input  name="customerName" value="" id="custinp" readonly></input>
      <div style="overflow:auto;max-height:200px" >      
        <table>
          <tbody id="taskstable">
            <tr><th>Uppgift</th><th>Datum</th><th>Mängd</th><th>Enhet</th><th>á Pris</th><th>Moms %</th></tr>
            <tr>
              <td><input type=text name="taskName" value="Städning" required ></input></td>
              <td><input type=date name="dates" required ></input></td>
              <td><input type=number name="amount" required ></input></td>
              <td><input type=text name="unit" style="width:50px" required value="h"></input></td>
              <td><input type=number name="unitPrice" value="20" required ></input></td>
              <td><input type=number name="taxPercentage" required value="24"></input></td>
            </tr>
          </tbody>
        </table>
      </div>
      <span style="float:left">Mängd uppgifter:</span>
      <input name="noTasks" value=1 style="width:50px;border:none;background:none;font-weight:bold"  id="nooftasks" readonly>
      </input>
      <div class="button" id="addtask" style="float:left;clear:left">+Lägg till</div>
      <div style="float:left;width:auto">
        <input type=radio name=payType value=0 checked style="margin:10px" />Kontantkvitto<br/>
        <input type=radio name=payType value=1 style="margin:10px" />Räkning 
      </div>
      <div style="float:left;width:auto">
        <input type=radio name=lang value=SWE checked style="margin:10px" />Svenska<br/>
        <input type=radio name=lang value=FIN style="margin:10px" />Finska 
      </div>
      <input type="submit" id="submit" name="createBill" style="width:100%;height:50px" class=button value="Skapa"></input>
    </div>
    </form>  


    <script>
    var billInMaking = {
      customer: "None",
      action: "None",
      hours: 0,
      totalPrice: 150
    } 
    function makeinp(type, para, number, name, defv) {
      var thing = document.createElement("td");
      para.appendChild(thing)
      var thing2 = document.createElement("input")
      thing2.setAttribute("type", type);
      thing2.setAttribute("name", name + number);
      thing2.setAttribute("class", "addedtask");   
      if (defv != undefined) {
        thing2.setAttribute("value", defv);
      }         
      thing.appendChild(thing2)
    }
    function payerthing()   {document.getElementById("betalare").hidden = true}
    function nopayerthing() {document.getElementById("betalare").hidden = false}
    document.getElementById("addshower").addEventListener("click", function() {document.getElementById("custAdder").hidden = false})
    document.getElementById("addtask").addEventListener("click", function() {
      var para = document.createElement("tr");
      para.setAttribute("id", "task" + taskCounter);
      var element = document.getElementById("taskstable");
      element.appendChild(para);
      var thing = document.createElement("td");
      para.appendChild(thing)
      var thing2 = document.createElement("input")
      thing2.setAttribute("name", "taskName" + taskCounter);
      thing2.setAttribute("value", "Städning")      
      thing.appendChild(thing2)
      makeinp("date", para, taskCounter, "dates")
      makeinp("number", para, taskCounter, "amount")
      makeinp("text", para, taskCounter, "unit","h")
      makeinp("number", para, taskCounter, "unitPrice",20)
      makeinp("number", para, taskCounter, "taxPercentage",24)
      taskCounter++
      document.getElementById("nooftasks").value = taskCounter
    })
    var taskCounter = 1
    var customers = document.getElementsByClassName("custitem")
    for (var i = 0; i < customers.length; i++) {
      customers[i].addEventListener('click', function(i) {
        for (var s=0; s < customers.length; s++) {customers[s].classList.remove("picked")}
        i.target.classList.add("picked")  
        document.getElementById("custinp").value = i.target.innerText
     });
    }
    
    document.getElementById("submit").addEventListener("click", function() {
      document.getElementById("bill").hidden = false
      document.getElementById("custName").innerHTML = document.getElementsByClassName("selected")[0].innerHTML
    })
  </script>
  <body>
</html>
