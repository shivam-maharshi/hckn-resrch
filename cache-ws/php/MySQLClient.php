<?php
error_reporting(E_ALL);
$title = $_GET["title"];
$conn = new mysqli("127.0.0.1","root","root","wiki");
if($conn->connect_error) {
  die("Connection failed ".mysqli_connect_error());
}
$sql0 = "select page_latest from page where page_title='".$title."' and page_namespace=0";
$result0 = $conn->query($sql0);
$row0 = $result0->fetch_assoc();
$oldId = $row0["page_latest"];
$sql1 = "select old_text from text where old_id = ".$oldId;
$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();
$data = $row1["old_text"];
print_r("Data : ".$data);
$conn->close();
?>
