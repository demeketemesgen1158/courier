<?php  
$servername="localhost";
$username="maflinkcom";
$password="B4mM8tO1bD9zP6x";
$dbname="maflinkcom_caseDB";

$orderNumber = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($_GET["orderNumber"])));

// Create connection
$conn=mysqli_connect($servername, $username, $password, $dbname);

//check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sqlSelect="SELECT status FROM caseOrder WHERE orderID = '$orderNumber'";
$selectResult=mysqli_query($conn, $sqlSelect);
if (mysqli_num_rows($selectResult)>0) {
    $row = mysqli_fetch_assoc($selectResult);
    $status = $row['status'];
	echo "
            <div class='trackDiv' style='margin: 30px 5%; font-family: sans-serif; font-size: 2.0em;'>
                <h3 class='trackH' style='font-size: 1.5em;'>Order number: <strong>".$orderNumber."</strong></h3>
                <div class='statusDiv' style='box-shadow: 11px 4px 9px -6px #1A9CFF; border-radius: 25px;'>
            	    <div class='delivered' style='background-color: #1A9CFF; color: white; padding: 1px 50px; border-radius: 21px; margin: 21px 10px;'>
                		<p><strong>".$status."</strong></p>
            	    </div>
                </div>
            </div>";
}
else{
	echo "
            <div class='trackDiv' style='margin: 30px 5%; font-family: sans-serif; font-size: 2.0em;'>
                <h3 class='trackH' style='font-size: 1.5em;'><strong>Order number is not available</strong></h3>
            </div>";
}
mysqli_close($conn);
?>