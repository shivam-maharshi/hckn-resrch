<?php

error_reporting(E_ALL);

$title = $_GET["title"];

print_r($title);

$conn = new mysqli("127.0.0.1","root","root","wiki");
if($conn->connect_error) {
	die("Connection failed ".mysqli_connect_error());
}

$sql = "select page_latest from page where page_title='".$title."' and page_namespace=0";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$oldId = $row["page_latest"];
print_r($oldId);

$sql1 = "select old_text from text where old_id = 5649748";
$result1 = $conn->query($sql1);
print_r($result1);
$row1 = $result1->fetch_assoc();
print_r($row1);
$data = $row1["old_text"];
print_r("Data : ".$data);

$conn->close();

?>
