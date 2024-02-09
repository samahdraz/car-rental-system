<!DOCTYPE html>
<html>

<head>
    <title>Report Results</title>
    <style>
        /* Add some CSS styles to format the results */
        table {

            border-collapse: collapse;
            width: 100%;
            border: 2px solid transparent;
            border-radius: 10px;
            outline: 3px solid black;

        }

        th {
            background-color: #aaa;
            width: inherit;
        }

        th,
        td {
            border: 2px solid black;
            padding: 8px;
            text-align: left;
        }


        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .gallery img {
            width: 100px;
            height: 100px;
            margin: 10px;
        }
    </style>
</head>

<body>
    <?php
    $ssn = $_POST['customerID'];
    $plate = $_POST['plate'];
    $start = $_POST['Date1'];
    $end = $_POST['Date2'];
    $day = $_POST['day'];
    $option = $_POST['type'];
    $conn = mysqli_connect("localhost", "root", "", "car rental system");
    if (!$conn) {

        echo "Connection failed!";

    } else {
        if ($option === "reservationsReport") {
            $stmt = $conn->prepare("SELECT * FROM reservation as r JOIN car as c on c.plate_id=r.plate_id join customer as cust on cust.ssn=r.ssn WHERE reservation_date BETWEEN '$start' and '$end'");
            $stmt->execute();
            $result = $stmt->get_result();
            echo "<table>";
            echo "<tr><th>
        ssn </th><th>plate_id </th><th>reservation_date </th><th>start_date </th><th>due_date </th><th>total_price </th><th>office_id </th><th>price </th><th>country </th><th>model </th><th>type </th><th>color </th><th>detail </th><th>image</th><th>	office_id </th><th>name </th><th>email </th><th>age </th><th>sex </th><th>country </th><th>visa_number </th><th>password</th></tr>";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ssn"] . "</td>";
                    echo "<td>" . $row["plate_id"] . "</td>";
                    echo "<td>" . $row["reservation_date"] . "</td>";
                    echo "<td>" . $row["start_date"] . "</td>";
                    echo "<td>" . $row["due_date"] . "</td>";
                    echo "<td>" . $row["total_price"] . "</td>";
                    echo "<td>" . $row["office_id"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td>" . $row["country"] . "</td>";
                    echo "<td>" . $row["model"] . "</td>";
                    echo "<td>" . $row["type"] . "</td>";
                    echo "<td>" . $row["color"] . "</td>";
                    echo "<td>" . $row["detail"] . "</td>";
                    $img_blob = $row['image'];
                    $img_src = 'data:image/png;base64,' . base64_encode($img_blob);
                    echo "<td><img src='" . $img_src . "' width='100px' height='100px'></td>";

                    echo "<td>" . $row["office_id"] . "</td>";
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
        } else if ($option === "reservationReport-2") {
            $stmt = $conn->prepare("SELECT * FROM reservation as r JOIN car as c on c.plate_id=r.plate_id WHERE reservation_date BETWEEN '$start' and '$end' and r.plate_id='$plate'");
            $stmt->execute();
            $result = $stmt->get_result();
            echo "<table>";
            echo "<tr><th>
        ssn </th><th>plate_id </th><th>reservation_date </th><th>start_date </th><th>due_date </th><th>total_price </th><th>office_id </th><th>price </th><th>country </th><th>image </th><th>model </th><th>type </th><th>color </th><th>detail </th></tr>";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ssn"] . "</td>";
                    echo "<td>" . $row["plate_id"] . "</td>";
                    echo "<td>" . $row["reservation_date"] . "</td>";
                    echo "<td>" . $row["start_date"] . "</td>";
                    echo "<td>" . $row["due_date"] . "</td>";
                    echo "<td>" . $row["total_price"] . "</td>";
                    echo "<td>" . $row["office_id"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td>" . $row["country"] . "</td>";
                    $img_blob = $row['image'];
                    $img_src = 'data:image/png;base64,' . base64_encode($img_blob);
                    echo "<td><img src='" . $img_src . "' width='100px' height='100px'></td>";
                    echo "<td>" . $row["model"] . "</td>";
                    echo "<td>" . $row["type"] . "</td>";
                    echo "<td>" . $row["color"] . "</td>";
                    echo "<td>" . $row["detail"] . "</td>";
                    echo "</tr>";
                }

            }
        } else if ($option === "carStatus") {
            $stmt = $conn->prepare("SELECT s.plate_id,s.status 
        FROM `status` as s 
        WHERE '$day'>s.start_date and '$day'< s.due_date
        UNION
        SELECT c.plate_id, 'active' 
        FROM car as c 
        WHERE c.plate_id NOT IN (SELECT plate_id FROM status as s WHERE '$day'>=s.start_date and '$day'<= s.due_date)");
            $stmt->execute();
            $result = $stmt->get_result();
            echo "<table>";
            echo "<tr><th>plate_id </th><th>Car status</th></tr>";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["plate_id"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "</tr>";
                }

            }

        } else if ($option === "customerReport") {
            $stmt = $conn->prepare("SELECT r.ssn ,r.plate_id ,r.reservation_date ,r.start_date ,r.due_date ,r.total_price ,r.office_id,c.name,c.email,c.age,c.sex,c.country,c.visa_number,c.password,car.model 	from reservation as r join customer as c on c.ssn=r.ssn join car on car.plate_id=r.plate_id where r.ssn=$ssn");
            $stmt->execute();
            $result = $stmt->get_result();
            echo "<table>";
            echo "<tr><th>
        ssn </th><th>plate_id </th><th>reservation_date </th><th>start_date </th><th>due_date </th><th>total_price </th><th>office_id </th> <th>model </th><th>name </th><th>email </th><th>age </th><th>sex </th><th>country </th><th>visa_number </th><th>password</th></tr>";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ssn"] . "</td>";
                    echo "<td>" . $row["plate_id"] . "</td>";
                    echo "<td>" . $row["reservation_date"] . "</td>";
                    echo "<td>" . $row["start_date"] . "</td>";
                    echo "<td>" . $row["due_date"] . "</td>";
                    echo "<td>" . $row["total_price"] . "</td>";
                    echo "<td>" . $row["office_id"] . "</td>";
                    echo "<td>" . $row["model"] . "</td>";
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

        } else if ($option === "payments") {
            $stmt = $conn->prepare("SELECT sum(r.total_price),r.reservation_date FROM reservation as r WHERE r.reservation_date BETWEEN '$start' and '$end' GROUP by r.reservation_date");
            $stmt->execute();
            $result = $stmt->get_result();
            echo "<table>";
            echo "<tr><th>
        Day </th><th>Daily revenue</th></tr>";
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<td>" . $row["reservation_date"] . "</td>";
                    echo "<td>" . $row["sum(r.total_price)"] . "</td>";
                    echo "</tr>";
                }

            }

        } else {
        }
    }
    ?>
</body>

</html>