<?php
$showAlert = false;
$name = $_POST['name'];
$password = $_POST['Password'];
$vv = $_POST['type'];
$conn = mysqli_connect("localhost", "root", "", "car rental system");
if (!$conn) {

    echo "Connection failed!";
} else {
    if ($vv === "Customer") {
        $stmt = $conn->prepare("SELECT ssn FROM Customer as C WHERE C.name='$name' and C.password='$password'");
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();
        if ($result->num_rows > 0) {
            $ssn = $rows['ssn'];
            session_start(); // Start the session
            $_SESSION['my_variable'] = $ssn;
            include("products.php");
        } else {
            $showAlert = true;
        }
        if ($showAlert) {
            echo '<script>alert("Wrong Email or Password.");</script>';
            include("login.html");
        }
    } else if ($vv === "admin") {
        $stmt2 = $conn->prepare("SELECT * FROM Admin WHERE name='$name' and password='$password'");
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2->num_rows > 0) {
            include("admin.html");
        } else {
            $showAlert = true;
        }
        if ($showAlert) {
            echo '<script>alert("Wrong Email or Password.");</script>';
            include("login.html");
        }
    } else {
        echo "choose customer or admin type";
    }
}
