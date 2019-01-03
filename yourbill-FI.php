<?php 
require_once("MysqliDb.php");
require_once("bills.php");
require_once("customers.php");
require_once("tasks.php");
$customer = new customers();
$bills = new bills();
$tasks = new tasks();
if (isset($_GET["billId"]) and ($_GET["billId"]!=0) and ($_GET["billId"]!=Null)) {
  $billId =$_GET["billId"];
  $bill = $bills->getBillBy($db,'id',$billId);
  $customer->getCustomerBy($db,"id", $bill[0]['customerId']);

}
else{
  redirectTo("index.php");
}

?>
<?php
function createUnique($viite){
  $yks = Array(7,1,3,7,1,3,7,1,3,7,1,3,7,1,3,7,1,3,7);
  $temp2 = 0;
  $viite = str_repeat("0", 19 - strlen($viite)) .$viite;
  for ($i = 0; $i < 19; $i++) {
      $temp[$i] = substr($viite, $i, 1) * $yks[$i];
  }
  for ($i = 0; $i < 19; $i++) {
      $temp2 = $temp2 + $temp[$i];
  }
  $tarkistus = 10 - substr($temp2, -1);
  if ($tarkistus == 10) {$tarkistus = 0;}
  return $tarkistus;
}



function redirectTo($page){
    header("Location: {$page}");
}

?>
<!DOCTYPE html>
<html>
  <head>
  <title>Bill</title>
  <script>

  </script>
  </head>
  <style>
    #servicetable, #servicetable th {
      border:1px solid #242424; 
      border-collapse: collapse;
      margin-top: 20px;
      margin-right: 5px
    }
    td {
      border-color: #242424;
      border-width: 0px 1px;
      padding: 5px 2px;
    }
    * {margin: 0}
  </style>
  <body>
    <div style="width:100%;height:101vw;margin: 0 0 20vw">
    <h1 style="text-align:center">
      <?php
      if ($bill[0]["payType"]==1) {
        echo "Lasku";
      }
      else{
        echo "Kuitti";
      }

      ?>
    </h1>    
    <div>
    <div style="float:left"><img src="logo.png" style="height:150px;" /></div>
    <div style="float:left;">
      <div style="margin:10px">
        <h2>Kickas Hemtjänst</h2>
        <p>Kyrkvallanrinne 26</p>
        <p>02400 Kirkkonummi</p>
        <p>2224808-2</p>
      </div>
      <div style="margin:10px;margin-top:30px">
        <?php 
          if ($customer->billPayer == 0) {
            echo "<h3>{$customer->billPayerName}</h3>".
                  "<p>{$customer->billPayeraddress}</p>".
                  "<p>{$customer->billPayerpost} {$customer->billPayercity}</p>";
            
          }
          else {
             echo "<h3>{$customer->name}</h3>".
                  "<p>{$customer->address}</p>".
                  "<p>{$customer->post} {$customer->city}</p>";           
          }
        ?>

      </div>
    </div>
    <div style="float:right">
      <table>
        <tr><td>Päiväys</td><td><?php echo $bill[0]["dates"]?></td></tr>
        <tr><td>Laskun numero</td><td><?php echo $bill[0]["id"]?></td></tr>
        <tr><td>Eräpäivä</td><td><?php $mod_date = strtotime($bill[0]["dates"]."+ 14 days"); echo date("d.m.Y",$mod_date);?></td></tr>
        <tr><td>Viivästyskorko</td><td>8.0%</td></tr>
        <tr><td>Viitenumero</td><td><?php echo $bill[0]["id"].createUnique($bill[0]["id"])?></td></tr>
      </table>
    </div>
    </div>
    <h3 style="clear:left;padding-top:50px">-</h3>
    <p>
      <?php
       if ($customer->billPayer == 0) {
           echo "<h3>{$customer->name}</h3>".
                "<p>{$customer->address}</p>".
                "<p>{$customer->post} {$customer->city}</p>";           

          }            

      ?>

    </p>
    <div style="margin:10px">
    <table style="border-collapse:collapse" id="servicetable">
      <tr>
        <th style="min-width:200px">Kuvaus</th>
        <th style="min-width:50px">Määrä</th>
        <th style="min-width:50px">Yksikkö</th>
        <th style="min-width:50px">á hinta</th>
        <th style="min-width:50px">Alv %</th>
        <th style="min-width:50px">Alv €</th>
        <th style="min-width:50px">Yhteensä</th>
      </tr>
      <?php
          $db->where ("billId", $bill[0]["id"]);
          $taskslist = $db->get("tasks");
          for ($n=0; $n <count($taskslist) ; $n++) { 
            echo "<tr><td>{$taskslist[$n]["taskName"]}</td>".
                "<td>{$taskslist[$n]["amount"]}</td>".
                "<td>{$taskslist[$n]["unit"]}</td>".
                "<td>".number_format((float)$taskslist[$n]["unitPrice"], 2, '.', '')." €</td>".
                "<td>{$taskslist[$n]["taxPercentage"]}</td>";
                $totalPrice[$n] = $taskslist[$n]["amount"]*$taskslist[$n]["unitPrice"];
                $TaxPrice[$n] = (bcdiv($totalPrice[$n],100,3)*$taskslist[$n]["taxPercentage"]);
                echo  "<td>".number_format((float)$TaxPrice[$n], 2, '.', '')." €</td>";                
                echo  "<td>".number_format((float)$totalPrice[$n], 2, '.', '')." €</td></tr>";
          }

      ?>
      
    </table>
    </div>
    <table style="float:right">
      <tr><td>Veroton hinta yht</td><td><?php $taxFreePrice = array_sum($totalPrice) - array_sum($TaxPrice) ; echo number_format((float)$taxFreePrice, 2, '.', '')." €"?></td></tr>
      <tr><td>Arvonlisävero yht</td><td><?php $totalTax=array_sum($TaxPrice); echo number_format((float)$totalTax, 2, '.', '')." €";?></td></tr>
      <tr><td>Yhteensä</td><td><?php $totalPay=array_sum($totalPrice); echo number_format((float)$totalPay, 2, '.', '')." €";?></td></tr>
    </table>
    <div style="position:absolute;top:130vw;width:100%">
    <p>Pyydämme käyttämään maksaessanne viitenumeroa: <span><?php echo $bill[0]["id"].createUnique($bill[0]["id"])?></span></p>
    <footer style="border-top: 1px solid #242424;width:100%">
    <table>
      <tr>
        <td>Kickas Hemtjänst Ab</td>
        <td>Ann-Christine Koroleff</td>
        <td>Pankki</td>
        <td>Ålandsbanken</td>
      </tr>
      <tr>
        <td>Kyrkvallanrinne 26</td>
        <td>Puh. 040-8482412</td>
        <td>Tilinumero</td>
      </tr>
      <tr>
        <td>02400 Kirkkonummi</td>
        <td>Sp: kickash70@gmail.com</td>
        <td>IBAN</td>
        <td>FI83 66010001059161</td>
      </tr>
    </table>
    </footer>
    <?php 
    echo "<script>window.print();</script>";
    


    ?>
    </div>
    </div>
  <body>
</html>
