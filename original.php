<?php
if(isset($_POST['submit'])){
  $name = $_POST['cust']; 
  $action = $_POST['action'];
  $hours = $_POST['hours'];
  $priceH = $_POST['priceH'];
  $total = $hours * $priceH;
  echo "this the bill for ".$name." he got ".$action." for ".$hours." hours and the total fees are ".$total." euros";
}
?>

<?php
    $mysqli = new mysqli("localhost", "root", "", "cleaningbills");
    $result = $mysqli->query("SELECT * FROM customers");  
?>

<!DOCTYPE html>
<html>
  <head>
  <title></title>
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
      padding: 20px
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
      cursor: pointer;
    }
    .selected {
      background-color: #65a3e2;
      cursor: auto;
    }
  </style>
  <body id="hid">
  <form method="POST" action="bill.php">    
    <div class="halfscreen" style="background-color:#fbefac">
      <h2 class="titles">Customers</h2>
      <div style="border: 2px solid #0a0500;overflow:auto;max-height:200px">
        <?php while ($cutomers = mysqli_fetch_assoc($result)) 
        {
          echo "<input class=\"customerRow\" type=\"radio\" name=\"cust\" value=\"{$cutomers['name']}\" \> {$cutomers['name']} <br>"; 
        }?>
      </div>
      <div>
        
      </div>
    </div>
    <div class="halfscreen" style="background-color:#f2e6a2">
      <h2 class="titles">Bills</h2>
      <div>
        <p>Action</p><input type=text name="action"></input>
        <p>No of hours</p><input type=number name="hours"></input>
        <p>price per hour</p><input type=number value=20 name="priceH"></input>
        <p>Create bill:</p><input type=submit id="submit" name="createbill"></input>
      </div>
    </div>
    </form>  
    <?php
    if(isset($_POST['submit'])){
      $result1 = $mysqli->query("SELECT * FROM customers WHERE name = '{$name}'");
       while ($custdata = mysqli_fetch_assoc($result1)) 
        {
          echo "<div id=\"bill\" style=\"width:100%\">".
            "<h1>BILL</h1>".
            "<p id=\"custName\">{$custdata['name']}</p>".
            "<p id=\"custAddr\">{$custdata['address']}</p>".
            "<p id=\"custTown\">{$custdata['post']}  {$custdata['city']} </p>".
            "<p id=\"service\">{$action}  </p>".
            "<p><span id=\"totalPrice\">{$total}</span>â‚¬</p>".
          "</div>" ;
        } 


    }
    ?>
    <!--<embed
    type="application/pdf"
    src="t.pdf"
    id="pdfDocument"
    width="100px"
    height="100px" />-->
    <script>
    var billInMaking = {
      customer: "None",
      action: "None",
      hours: 0,
      totalPrice: 150
    }
    var customers = document.getElementsByClassName("customerRow")
    for (var i = 0; i < customers.length; i++) {
      customers[i].addEventListener('click', function(i) {
        for (var s=0; s < customers.length; s++) {customers[s].classList.remove("selected")}
        i.target.classList.add("selected")  
     });
    }
    document.getElementById("submit").addEventListener("click", function() {
      document.getElementById("bill").hidden = false
      document.getElementById("custName").innerHTML = document.getElementsByClassName("selected")[0].innerHTML
    })
  </script>
  <body>
</html>