<!DOCTYPE html>
<html>
<head>
  <title>Report Results</title>
  <style>
    /* Add some CSS styles to format the results */
    table {
      border-collapse: collapse ;
      width: 100%;
      border: 2px solid transparent;
      border-radius: 10px;
      /* border-color: red; */
      outline: 3px solid black;
      
    }
    
    th{
      background-color: #aaa;
      width: inherit;
    }

    th, td {
      border: 2px solid black;
      /* border-radius: 10px; */
      padding: 8px;
      text-align: left;
    }
    
    
    .gallery {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }
    
    .gallery img {
      /* width: fit-content; */
      height: 100px;
      margin: 10px;
    }
  </style>
</head>
<body>
<?php

$value = $_POST['value'];
$attr = $_POST['modification'];
$table= $_POST['type'];


$conn = mysqli_connect("localhost", "root", "", "car rental system");
if (!$conn) {

    echo "Connection failed!";

}else {
    if($table === "Car"){
    $stmt = $conn->prepare("SELECT * FROM $table where $attr='$value'");
    $stmt->execute();
    $result = $stmt->get_result();
    echo "<table class='table table-primary'>";
        echo "<tr><th scope='col'>plate_id </th><th>price </th><th>country </th><th>model </th><th>type </th><th>color </th><th>detail </th><th>image </th><th>office_id</th></tr>"; 
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["plate_id"] . "</td>";
                echo "<td>" . $row["price"] . "</td>";
                echo "<td>" . $row["country"] . "</td>";
                echo "<td>" . $row["model"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td>" . $row["color"] . "</td>";
                echo "<td>" . $row["detail"] . "</td>"; 
                $img_blob = $row['image'];
                $img_src = 'data:image/png;base64,' . base64_encode($img_blob);
                echo "<td><img src='" . $img_src . "' width='fit-content' height='100px'></td>";
                echo "<td>" . $row["office_id"] . "</td>"; 
                echo "</tr>";
            }
          }    }
    else if($table === "Customer"){
        $stmt = $conn->prepare("SELECT * FROM $table where $attr='$value'");
        $stmt->execute();
        $result = $stmt->get_result(); 
        echo "<table>";
        echo "<tr><th>
        ssn </th><th>name </th><th>email </th><th>age </th><th>sex </th><th>country </th><th>visa_number </th><th>password</th></tr>";
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
        echo "<td>" . $row["ssn"] . "</td>"; 
        echo "<td>" . $row["name"] . "</td>"; 
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["age"] . "</td>";
        echo "<td>" . $row["sex"] . "</td>";
        echo "<td>" . $row["country"] . "</td>"; 
        echo "<td>" . $row["visa_number"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        echo "</tr>";
                }
              } 
    }
    else{
        $stmt = $conn->prepare("SELECT * FROM $table where $attr='$value'");
    $stmt->execute();
    $result = $stmt->get_result(); 
    echo "<table>";
        echo "<tr><th>
        ssn </th><th>plate_id </th><th>reservation_date </th><th>start_date </th><th>due_date </th><th>total_price </th><th>office_id </th></tr>";
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ssn"] . "</td>"; 
        echo "<td>" . $row["plate_id"] . "</td>";
        echo "<td>" . $row["reservation_date"] . "</td>";
        echo "<td>" . $row["start_date"] . "</td>"; 
        echo "<td>" . $row["due_date"] . "</td>";
        echo "<td>" . $row["total_price"] . "</td>";
        echo "<td>" . $row["office_id"] . "</td>";
                echo "</tr>";
            }
          } 

    }  

}
?>
</body>
</html>