<?php
$result = mysqli_connect("localhost", "root", "", "Car rental system") or die("Could not connect to database." . mysqli_error());
mysqli_select_db($result, "Car rental system") or die("Could not select the database." . mysqli_error());



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="styles1.css">
    <script src="https://kit.fontawesome.com/1056a9816d.js" crossorigin="anonymous"></script>
    <title>Products</title>
    <style>
        main.container {
            position: relative;
            top: 0px;
        }

        main.container > .row > .col-md-3 > form > .img > img:hover {
            transform: scale(0.9);
            border-radius: 15px;
            cursor: pointer;
            transition: all ease 0.3s;
        }
       
    </style>

</head>

<body>
    <div class="container-fluid header p-2 text-bg-secondary d-flex justify-content-center align-items-center h-container">
        <header>
            <h1><i class="fa-solid fa-leaf"></i> Car Rental System </h1>
        </header>
    </div>
    
    <form id="products.php" action="products.php" method="post">
        <div class="container">
            <!-- <div class="hisham"> -->
            <label for="" id="nameFady"></label>
            <label for='update' style="position: relative; left: 250px;"></label><br>
            <label for="" id="nameFady"></label>
            <div class="container d-flex justify-content-around" style="position: relative;top: 100px;">

                <select id="modification" name="modification" class="Modification py-2 m-2">
                    <!-- 
                                    "plate_id", "price", "country", "model", "type ", "color", "detail ", "office_id"]
                                -->
                    <option value="plate_id">Car Id</option>
                    <option value="price">Price Per Day</option>
                    <option value="country">Car Country</option>
                    <option value="model">Model</option>
                    <option value="type">Type</option>
                    <option value="color">Color</option>
                    <!-- <option value="detail">detail</option> -->
                    <option value="office_id">Office Country</option>
                </select>

                <!-- <label for="name" class="form-label">Value</label> -->
                <input type="text" name="value" id="value" class="form-control w-100 " placeholder="Search" aria-describedby="helpId">
                <label for="" id="nameFady"></label>
            </div>
            <div class="d-flex justify-content-around   align-items-center w-100 my-5">
                <input name="submit" id="submit" class="btn w-25 btn-primary py-2 centered-button2" type="submit" value="Advanced Search">
                
            </div>
        </div>
       </form>
    
    </div>
    <main class="container">
        <div class="row">
            <?php
            if (isset($_POST['modification'], $_POST['value']) && !empty($_POST['modification']) && !empty($_POST['value'])) {
                $attr = $_POST['modification'];
                $value = $_POST['value'];

                if ($attr === "office_id") {
                    $stmt = $result->prepare("SELECT office_id FROM office WHERE country=?");
                    $stmt->bind_param("s", $value);
                    $stmt->execute();
                    $resultOffice = $stmt->get_result();

                    if ($resultOffice->num_rows > 0) {
                        $row = $resultOffice->fetch_assoc();
                        $value = $row["office_id"];
                    }
                }

                $image_query = mysqli_query($result, "SELECT c.`plate_id`,c.`price` ,c.`country` ,c.`model` ,c.`type` ,c.`image` ,c.`color` ,`office_id` ,s.`status`,s.`start_date`, s.`due_date`
            from car as c LEFT JOIN `status` as s 
            ON c.plate_id = s.plate_id
            where c.$attr='$value'");
            } else {
                $image_query = mysqli_query($result, 'SELECT c.`plate_id`,c.`price` ,c.`country` ,c.`model` ,c.`type` ,c.`image` ,c.`color` ,s.`status`, s.`start_date`, s.`due_date`
            from car as c LEFT JOIN `status` as s 
            ON c.plate_id = s.plate_id');
            }
            while ($rows = mysqli_fetch_array($image_query)) {
                $img_blob = $rows['image'];
                $img_src = 'data:image/jpg;base64,' . base64_encode($img_blob);
                // Extract the 'id' column
                $car_status = $rows['status'];
                $car_price = $rows['price'];
                $car_model = $rows['model'];
                $car_type = $rows['type'];
                $car_color = $rows['color'];
                $plate_id = $rows['plate_id'];
                $car_country = $rows['country'];
                $start_date = $rows['start_date'];
                $end_date = $rows['due_date'];

            ?>
                <div class="col-md-3 mb-3">
                    <form action="reservecar.php" method="get" id="form_<?php echo $plate_id; ?>">
                        <div class="img" onclick="submitForm('<?php echo $plate_id; ?>')">
                            <img src="<?php echo $img_src; ?>" alt="" class="w-75">
                            <label class="text-secondary mx-2 d-block">
                                <?php
                                if ($car_status) {
                                    echo 'Status: ' . $car_status . '<br>';
                                    echo 'Start Date: ' . $start_date . '<br>';
                                    echo 'End Date: ' . $end_date . '<br>';
                                } else {
                                    echo "Status: Active <br>";
                                }

                                echo 'Price Per Day: ' . $car_price . '<br>';
                                echo 'Car Model: ' . $car_model . '<br>';
                                echo 'Car Type: ' . $car_type . '<br>';
                                echo 'Car Color: ' . $car_color . '<br>';
                                echo 'Car Country: ' . $car_country . '<br>';
                                ?>
                            </label>
                        </div>
                        <input type="hidden" name="plate_id" value="<?php echo $plate_id; ?>">
                    </form>
                </div>
            <?php
            }
            ?>
        </div>
    </main>

    <script>
        function submitForm(plateId) {
            document.getElementById('form_' + plateId).submit();
        }
    </script>

</body>

</html>