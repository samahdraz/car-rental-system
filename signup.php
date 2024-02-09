<?php

$name = $_POST['name'];
$email = $_POST['email'];
$ssn = $_POST['ssn'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$country = $_POST['country'];
$ccn = $_POST['ccn'];
$password = $_POST['Password'];

if ($gender === "male") {
    $gender = "male";
} else {
    $gender = "female";
}
$conn = mysqli_connect("localhost", "root", "", "car rental system");
if (!$conn) {

    echo "Connection failed!";
} else {
    $stmt = $conn->prepare("SELECT ssn FROM Customer WHERE ssn=$ssn");
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $showAlert = true;
    } else {
        $stmt2 = $conn->prepare("insert into Customer(name, email,ssn,sex,age,country,visa_number, password) values(?, ?, ?,?, ?, ?,?, ?)");
        $stmt2->bind_param("ssssssss", $name, $email, $ssn, $gender, $age, $country, $ccn, $password);
        $execval = $stmt2->execute();

        session_start(); // Start the session
        $_SESSION['my_variable'] = $ssn;


        include("products.php");
    }
    if ($showAlert) {
        echo '<script>alert("Repeated SSN.");</script>';
        include("signup.html");
    }
}
