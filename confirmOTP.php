<?php  
$servername="localhost";
$username="maflinkcom";
$password="B4mM8tO1bD9zP6x";
$dbname="maflinkcom_caseDB";
//create connection

$objData=$_GET["q"];
$data=json_decode($objData, true);

$otp = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["otPass"])));
$yName = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["yourName"])));

$headers = "From: info@maflink.com";
$to = " ";
$subject ="Order placed";

// Create connection
$conn=mysqli_connect($servername, $username, $password, $dbname);

//check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sqlSelect="SELECT * FROM caseOrder WHERE yName = '$yName' AND OTP = '$otp'";
$selectResult=mysqli_query($conn, $sqlSelect);
if (mysqli_num_rows($selectResult)>0) {
	while($row=mysqli_fetch_assoc($selectResult)){
	    $orderID = $row['orderID'];
        $txt = "Your order number is: ".$orderID;
	    $to = $row['email'];
	}
	$sqlUpdate = "UPDATE caseOrder SET OTP='0', status='submitted' WHERE yName='$yName' AND OTP = '$otp'";
	if ($conn->query($sqlUpdate) === TRUE) {
		echo $orderID;
        mail($to, $subject, $txt, $headers);
	} 
	else {
  		echo "Error";
	}
}
else{
	echo "invalid";
}
mysqli_close($conn);
?>