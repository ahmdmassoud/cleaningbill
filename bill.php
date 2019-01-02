<?php

require_once("MysqliDb.php");
$name = $_POST['cust']; 
$action = $_POST['action'];
$hours = $_POST['hours'];
$priceH = $_POST['priceH'];
$total = $hours * $priceH;
echo "this the bill for ".$name." he got ".$action." for ".$hours." hours and the total fees are ".$total." euros";





?>

<?php
function createUnique($viite){
  $yks = Array(7,1,3,7,1,3,7,1,3,7,1,3,7,1,3,7,1,3,7);
  //$viite = "12345";
  $viite = str_repeat("0", 19 - strlen($viite)) .$viite;
  for ($i = 0; $i < 19; $i++) {
      $temp[$i] = substr($viite, $i, 1) * $yks[$i];
  }
  for ($i = 0; $i < 19; $i++) {
      $temp2 = $temp2 + $temp[$i];
  }
  $tarkistus = 10 - substr($temp2, -1);
  if ($tarkistus == 10) {$tarkistus = 0;}
  print "Tarkistusnumero: " .$tarkistus;
}

createUnique("2");
?>
<!DOCTYPE html>
<html>
  <head>
  <title></title>
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
      border-width: 0px 1px
    }
    * {margin: 0}
  </style>
  <body style="width:100%;height:101vw;margin: 0 0 20vw;background-color:#e4a1b7">
    <h1 style="text-align:center">Kontantkvitto</h1>    
    <div>
    <div style="float:left;background-color:#4af25b">
      <div style="margin:10px">
        <h2>Kickas Hemtjänst</h2>
        <p>Kyrkvalla 23</p>
        <p>02400 Kirkkonummi</p>
        <p>2224808-2</p>
      </div>
      <div style="margin:10px;margin-top:30px">
        <h3><?php echo $name?></h3>
        <p>{{cust.streetaddr}}</p>
        <p>{{cust.town}}</p>
      </div>
    </div>
    <div style="float:right">
      <table>
        <tr><td>Datum</td><td><?php $d = date("d.m.Y"); echo $d;?></td></tr>
        <tr><td>Fakturans nummer</td><td>{{unique_number}}</td></tr>
        <tr><td>Förfallodag</td><td><?php $mod_date = strtotime($d."+ 14 days"); echo date("d.m.Y",$mod_date);?></td></tr>
        <tr><td>Dröjsmålsränta</td><td>8.0%</td></tr>
        <tr><td>Referensnummer</td><td>{{functionA(unique_number)}}</td></tr>
      </table>
    </div>
    </div>
    <h3 style="clear:left;padding-top:50px">Tilläggsinformation</h3>
    <p>{{more_information}}</p>
    <div style="margin:10px">
    <table styl e="border-collapse:collapse" id="servicetable">
      <tr>
        <th>Beskrivning</th>
        <th>Antal</th>
        <th>Enhet</th>
        <th>á pris</th>
        <th>Moms %</th>
        <th>Moms €</th>
        <th>Totalt</th>
      </tr>
      <tr>
        <td>{{service1.description}}</td>
        <td>{{service1.amount}}</td>
        <td>{{service1.unit}}</td>
        <td>{{service1.unitprice}}</td>
        <td>{{service1.momsPercent}}</td>
        <td>{{service1.momsEuro}}</td>
        <td>{{service1.totalPrice}}</td>
      </tr>
      <tr><td>...<td></tr>
      <tr>
        <td>{{serviceN.description}}</td>
        <td>{{serviceN.amount}}</td>
        <td>{{serviceN.unit}}</td>
        <td><?php echo $priceH ?></td>
        <td>{{serviceN.momsPercent}}</td>
        <td>{{serviceN.momsEuro}}</td>
        <td>{{serviceN.totalPrice}}</td>
      </tr>
    </table>
    </div>
    <table style="float:right">
      <tr><td>Skattefritt pris</td><td>{{taxfreeprice}}</td></tr>
      <tr><td>Moms totalt</td><td>{{tax}}</td></tr>
      <tr><td>Summa med moms</td><td>{{totalTaxedPrice}}</td></tr>
    </table>
    <div styl e="position:absolute;bottom:0;height:20vw;width:100%">
    <p>Vi ber att Ni använder referensnumret: <span>{{functionA(unique_number)}}</span></p>
    <footer sty le="border-top: 1px solid #242424;width:100%">
    <table>
      <tr>
        <td>Kickas Hemtjänst Ab</td>
        <td>Ann-Christine Koroleff</td>
        <td>Bank</td>
        <td>Ålandsbanken</td>
      </tr>
      <tr>
        <td>Kyrkvalla 23</td>
        <td>Tel. 040-8482412</td>
        <td>Kontonummer</td>
      </tr>
      <tr>
        <td>02400 Kirkkonummi</td>
        <td>Epost: kickash70@gmail.com</td>
        <td>IBAN</td>
        <td>FI83 66010001059161</td>
      </tr>
    </table>
    </footer>
    </div>
  <body>
</html>