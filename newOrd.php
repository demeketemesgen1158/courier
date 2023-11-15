<?php
$servername="localhost";
$username="maflinkcom";
$password="B4mM8tO1bD9zP6x";
$dbname="maflinkcom_caseDB";

$objData=$_GET["q"];
$data=json_decode($objData, true);

$yourName = preg_replace("/\r?\n/", "\\n", addslashes($data["yourName"]));
$yourName = htmlspecialchars($yourName);

$fatherName = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["fatherName"])));
$grandfName = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["grandfName"])));
$emailX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["emailX"])));
$pNumberX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["pNumberX"])));
$countryX =htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["countryX"])));
$stateX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["stateX"])));
$cityX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["cityX"])));
$stAddr1X =htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["stAddr1X"])));
$stAddr2X = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["stAddr2X"])));
$postalCodeX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["postalCodeX"])));
$caseTypeX =htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["caseTypeX"])));
$issuedByX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["issuedByX"])));
$issueIdX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["issueIdX"])));
$addDetailX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["addDetailX"])));
$termX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["termX"])));
$privacyX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["privacyX"])));

$id = "";
$orderID = 67100000;
$status = "waiting for payment";

$OTP =rand(1000, 10000); 
$headers = "From: info@maflink.com";
$to = $emailX;
$subject ="GooRap CaseOrder - Payment Confirmation";
$txt = "Your payment confirmation OTP is: ".$OTP;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sqlSelect="SELECT MAX(id) AS lastId FROM caseOrder";
$sqlResult=mysqli_query($conn, $sqlSelect);
if (mysqli_num_rows($sqlResult)>0) {
	while($row=mysqli_fetch_assoc($sqlResult)){
	    $id = $row['lastId'];
	}
}
else{
	echo "Error";
    }

$orderID = $orderID+$OTP*10+$id+1;
$sql = "INSERT INTO caseOrder (yName, fName, gfName, email, phoneNumber, country, state, city, st1, st2, postCode, caseType, issueBy, issueOrdId, additional, term, privacy, orderID, status, OTP) VALUES ('$yourName', '$fatherName', '$grandfName', '$emailX', '$pNumberX', '$countryX', '$stateX', '$cityX', '$stAddr1X', '$stAddr2X', '$postalCodeX', '$caseTypeX', '$issuedByX', '$issueIdX', '$addDetailX', '$termX', '$privacyX', '$orderID', '$status', '$OTP')";

if ($conn->query($sql) === TRUE) {
    mail($to, $subject, $txt, $headers);
    echo "Payment confirmation code is sent to you. Insert the OTP to complete";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>