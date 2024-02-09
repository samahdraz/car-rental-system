<?php

$plate = $_POST['plate'];

$conn = mysqli_connect("localhost", "root", "", "car rental system");
if (!$conn) {

    echo "Connection failed!";

}else {
    $stmt = $conn->prepare("SELECT plate_id FROM Car WHERE plate_id=$plate");
    $stmt->execute();
    $result = $stmt->get_result(); 
        if ($result->num_rows > 0) {
            $stmt2 = $conn->prepare("SELECT plate_id FROM Reservation WHERE plate_id=$plate");
            $stmt2->execute();
            $result2 = $stmt2->get_result(); 
                if ($result2->num_rows > 0) {
                    echo "Car is rented so it can't be deleted";
                }
                else{
                    $stmt3 = $conn->prepare("DELETE FROM Car WHERE plate_id=$plate");
                    $stmt3->execute(); 
                }
          }      
else {
    echo "No Cars with that Plate id";
}


}
?>