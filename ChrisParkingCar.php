<?php

// http://localhost/PhpProject1/ChrisParkingCar.php?smsID=1&MSISDN=359899866747&msp=87&smsBody=CA5151PC 
error_reporting(E_ALL);   //set error reporting

$PricePerHour = 2; //levs parking per Hour
$fDBG = FALSE; // TRUE;   //
//	open connection  and select DB
$link = mysqli_connect("localhost", "root", "", "DBparkingcar");
if (!$link) {
    echo "-ERR LINK MySQL Error: " . mysql_error();
    exit();
}
if (!(mysqli_select_db($link, "DBparkingcar"))) {
    echo "-ERR no selected DB MySQL Error:" . mysql_error();
    exit();
}
//	get data from $_GET
$smsID = $_GET["smsID"];
$MSISDN = $_GET["MSISDN"];
$mobileSP = $_GET["msp"];
$CarNumber = $_GET["smsBody"];
// prepare data (delete space and etc.)
$smsID = addslashes($smsID);
$MSISDN = addslashes($MSISDN);
$mobileSP = addslashes($mobileSP);
$CarNumber = addslashes($CarNumber);
//	Check if  the driver is already registered as incoming
$selectSQL = "      SELECT 
    * FROM 
            parktimes 
    WHERE 
          MSISDN = '$MSISDN'      AND 
         CarNumber = '$CarNumber'   AND
         TimeOut = '0000-00-00 00:00:00'    
";

$rSelect = mysqli_query($link, $selectSQL);
//  check result
if ($rSelect == false) {
    echo "-ERR MySQL ** Error: " . mysqli_error() . "\nSQL: $selectSQL";
    exit();
}

$NumOfRows = mysqli_num_rows($rSelect);
if ($NumOfRows == 0) { //The Driver comes for the 1-st time   
    $TimeIn1 = date('Y-m-d H:i:s'); // used instead of NOW() to preven 1 hour difference

    $insertSQL = "INSERT
                   INTO
                      parktimes (  MSISDN, CarNumber, TimeIn) 
                      VALUES  (  '$MSISDN', '$CarNumber', '$TimeIn1' )
                 ";
    $rInsert = mysqli_query($link, $insertSQL);
    if ($rInsert == false) {
        echo "-ERR MySQL Error:" . mysqli_error() . "\nSQL: $insertSQL";
        exit();
    }
    $TimeStr = date("h:ia");
    if ($fDBG)
        echo "<br><br>";
    echo "+OK $MSISDN with car $CarNumber is registered successfully on  $TimeStr";
    $TimeStr1 = date("h:i:s"); // to see and seconds
    // if ($fDBG)        echo "<br>You: $MSISDN are registered  as incoming at  $TimeStr1";
    exit();
} else {    // The driver comes for 2-nd time
    $row = mysqli_fetch_array($rSelect);
    $TimeIn = $row['TimeIn'];    //Take time from the Tin table
    $TimeOut = date('Y-m-d H:i:s');  // define the moment for outgoing
    if ($fDBG) {
        echo "<br>The Driver $MSISDN comes for the 2-nd time:::";
        echo "<br>TimeOut = $TimeOut";
        echo "<br>_TimeIn = $TimeIn";
    }
    // find time difference
    $start_date = new DateTime($TimeIn);
    $since_start = $start_date->diff(new DateTime($TimeOut));
    $days = $since_start->d;
    $hours = $since_start->h;
    $min = $since_start->i;
    $TotTime = 24 * $days + $hours + $min / 60.0; // for example 2+30/60=2.5
    // find sum for paying
    $SumForPay = $TotTime * $PricePerHour;
    $formatted = sprintf("%10.2f", $SumForPay);
    echo "+OK Sum for pay (for time= 24*$days+$hours hours and $min min) is $formatted lv.for $CarNumber
        ($PricePerHour lv per hour)";

    //	update SQL
    $updateSQL = "
		UPDATE 
			parktimes 
		SET 
			TimeOut = '$TimeOut' 
		WHERE 
          MSISDN = '$MSISDN'      AND 
          CarNumber = '$CarNumber'   AND
          TimeOut = '0000-00-00 00:00:00'   
	";
    $rUpdate = mysqli_query($link, $updateSQL);
    if ($rUpdate == false) {
        echo "-ERR MySQL Error:" . mysqli_error() . "\nSQL: $insertSQL";
        exit();
    }
}// else for the second time
mysqli_close($link);
?>