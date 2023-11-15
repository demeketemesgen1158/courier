<?php  
$servername="localhost";
$username="maflinkcom";
$password="B4mM8tO1bD9zP6x";
$dbname="maflinkcom_caseDB";

$data=json_decode($_GET["q"], true);
$nameX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["nameX"])));

$valueX = htmlspecialchars(preg_replace("/\r?\n/", "\\n", addslashes($data["valueX"])));

if($nameX!="" && $valueX!=""){
    $filter = "$nameX='$valueX'";
}
else{
    $filter = 1;
}

//create connection
$conn=mysqli_connect($servername, $username, $password, $dbname);

//check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql="SELECT * FROM caseOrder WHERE $filter";
$result=mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
	//output data of each row
	$inx=1;
	echo '{"0":{"0":{"0":"NO"}}';
	while($row=mysqli_fetch_assoc($result)){
		$data = new stdClass();
        $data->$inx=$row;
		$data = json_encode($data);
    	echo ",".'"'."$inx".'"'.":";
    	echo $data;
    	$inx=$inx+1;
	}
	echo "}";
}
else{
	echo "No results found";
}
mysqli_close($conn);
?>