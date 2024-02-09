<?php
$plate=$_POST["plate"];
$status=$_POST["type"];
$start = $_POST['Date1'];
$end = $_POST['Date2'];
$start1 = $_POST['Date3'];
$end1 = $_POST['Date4'];
$conn = mysqli_connect("localhost", "root", "", "car rental system");
if (!$conn) {

    echo "Connection failed!";

}else {
    $stmt = $conn->prepare("SELECT plate_id FROM Car WHERE plate_id=$plate");
    $stmt->execute();
    $result = $stmt->get_result(); 
        if ($result->num_rows > 0) {
            $stmt2 = $conn->prepare("Delete from status where plate_id='$plate' and start_date='$start' and due_date='$end'");
            $stmt2->execute();
            $result = $stmt2->get_result(); 
     if($status==="active"){
        include("updatecar.html");
     }
     else{       
    $stmt3 = $conn->prepare("INSERT INTO `status` VALUES('$plate', '$status', '$start1', '$end1')");
    $stmt3->execute();
    // $result = $stmt->get_result(); 
    include("updatecar.html");}
     }
    else{
        $showAlert = true;
    }  
    if ($showAlert) {
        echo '<script>alert("No Car with that plate id.");</script>';
        include("updatecar.html");
    }
}
?>
