<?php
if(isset($_SERVER['HTTP_REFERER'])) {
  $previous = $_SERVER['HTTP_REFERER'];
}

session_start(); // Start the session (this must be called on each page)
$ssnValue = $_SESSION['my_variable']; // Access the variable from Page 1

if (isset($_GET['plate_id'])) {
  $plate_id = $_GET['plate_id'];
} else {
  // Handle the case when plate_id is not provided in the URL
  echo "Plate ID not provided.";
  exit();
}
$conn = mysqli_connect("localhost", "root", "", "car rental system");

$stmt = $conn->prepare("SELECT c.`price` ,c.`country` ,c.`model` ,c.`type` ,c.`image` ,c.`color`, c.`office_id`, c.`detail`,
s.`status`,s.`start_date`, s.`due_date`
from car as c left join `status` as s
on c.plate_id = s.plate_id
where c.plate_id = ? ");
$stmt->bind_param("s", $plate_id);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_assoc();
$img_blob = $rows['image'];
$img_src = 'data:image/jpg;base64,' . base64_encode($img_blob);

$car_status = $rows['status'];
$car_price = $rows['price'];
$car_model = $rows['model'];
$car_type = $rows['type'];
$car_color = $rows['color'];
//$plate_id = $rows['c.plate_id'];
$car_country = $rows['country'];
$start_date = $rows['start_date'];
$end_date = $rows['due_date'];
$office_id = $rows['office_id'];
$details = $rows['detail'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <link rel="stylesheet" href="styles1.css" />
  <script src="https://kit.fontawesome.com/1056a9816d.js" crossorigin="anonymous"></script>
  <title>Reserve A Car</title>
  <style>
    .hidden-label {
      display: none;
    }

    p.w-75 {
      margin-left: 35px;
    }

    #myForm {
      position: relative;
      top: -40px;
    }

    #plateIdDisplay {
      font-size: large;
    }

    /* Adjust the date input size */
    #start_date,
    #due_date {
      height: 38px;
      font-size: 14px;
    }

    .font-monospace {
      font-size: 50px;
    }

    .input-group {
      z-index: 0;
    }

    /* Add margin to the calendar button */

    .input-group-addon {
      /*position: absolute;*/
      cursor: pointer;
      /* Add pointer cursor for better interaction */
      margin-left: -30px;

      left: 50px;
    }
  </style>
  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Include Bootstrap Datepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>

<body>
  
  <div class="card text-start d-flex justify-content-center align-items-center">
    <div class="card-body w-50">
      <h4 class="card-title font-monospace">Reserve Car</h4>
      <div class="img d-flex flex-column justify-content-center align-items-center">
        <img id="imageDisplay" class="img-fluid rounded-top" src="<?php echo $img_src; ?>" alt="" style="width: fit-content" />
        <p class="text-secondary p-2 w-75">
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
          echo 'Details: ' . $details . '<br>';

          ?>
        </p>
      </div>
      <?php

      // Check if the form is submitted
      if ($_SERVER['REQUEST_METHOD'] === 'POST'  && isset($_POST['submit'])) {
        // Access the value entered in the ssn input using $_POST
        if (isset($_POST['start_date'], $_POST['due_date'])) {
          //$ssnValue = $_POST['ssn'];
          $startDate = $_POST['start_date'];
          $dueDate = $_POST['due_date'];

          reserveCar();
        } else {
          echo "ay haga";
        }
      }
      function reserveCar()
      {
        global $ssnValue, $startDate, $dueDate, $car_price, $car_status, $office_id, $plate_id; // Use global to access variables outside the function
        $conn = mysqli_connect("localhost", "root", "", "car rental system");

        // Calculate the difference in days
        $startDateObj = new DateTime($startDate);
        $dueDateObj = new DateTime($dueDate);
        $interval = $startDateObj->diff($dueDateObj);
        $daysDifference = $interval->days;

        // Calculate the total price
        $totalPrice = $daysDifference * $car_price;
        //echo $totalPrice;

        $sql_rev = "INSERT INTO reservation (ssn, plate_id, reservation_date, `start_date`, due_date, total_price, office_id)
        VALUES ('$ssnValue', '$plate_id', DATE(NOW()), '$startDate', '$dueDate', '$totalPrice', '$office_id')";

        $sql_status = "INSERT INTO status (plate_id, `status`, `start_date`, due_date)
        VALUES ('$plate_id', 'Rented', '$startDate', '$dueDate')";

        //echo $plate_id;
        if ($conn->query($sql_rev) === TRUE  && $conn->query($sql_status) === TRUE) {
          //echo "Record inserted successfully into the 2 table";
        } else {
          echo "Error";
        }
      }
      $conn->close();
      ?>
      <form id="myForm" method="post" enctype="multipart/form-data">

        <div class="container w-75">
          <div class="hisham">

            <!-- <label for="ssn" class="form-label">SSN Number</label>
            <input type="text" name="ssn" id="ssn" class="form-control w-100" placeholder="Social Security No." aria-describedby="helpId" required> -->

            <div class="d-flex flex-column">
              <label for="plate_id" id="plateIdDisplay" class="d-block my-2">
                <label for="plate_id" id="plateIdDisplay" value="plateId"></label>
                <label for="" id="plateIdDisplay"></label>
                <label>Duration:</label>

                <div class="date-container d-flex flex-row">
                  <!-- <div class="d-flex flex-row"> -->
                  <label for="start_date" class="form-label me-3">Start Date</label>
                  <div class="input-group">
                    <input type="date" name="start_date" id="start_date" class="form-control w-auto" placeholder="Start Date" aria-describedby="helpId" required />
                    <!-- <span class="input-group-addon">
                        <i
                          class="glyphicon glyphicon-calendar"
                          onclick="$('#start_date').datepicker('show');"
                        ></i>
                      </span> -->
                  </div>
                  <!-- </div> -->

                  <label for="due_date" class="form-label me-3">Due Date</label>
                  <div class="input-group">
                    <input type="date" name="due_date" id="due_date" class="form-control w-auto" placeholder="Due Date" aria-describedby="helpId" required />
                  </div>

                  <script>
                    // Get the input element
                    var dueDateInput = document.getElementById('due_date');
                    var startDateInput = document.getElementById('start_date');
                    var label = document.getElementById('hiddenText');

                    //startDateInput.addEventListener('input', calculateDateDifference);
                    dueDateInput.addEventListener('input', calculateDateDifference);

                    function calculateDateDifference() {
                      // Get the values of the start date and due date inputs
                      var startDateValue = startDateInput.value;
                      var dueDateValue = dueDateInput.value;

                      // Convert the date strings to Date objects
                      var startDate = new Date(startDateValue);
                      var dueDate = new Date(dueDateValue);

                      // Calculate the difference in milliseconds
                      var differenceInMilliseconds = dueDate - startDate;

                      // Convert the difference to days
                      var differenceInDays = differenceInMilliseconds / (1000 * 60 * 60 * 24);

                      var price = <?php echo $car_price; ?>;

                      var total = price * differenceInDays;

                      hiddenText.textContent =  total.toFixed(2) ;
                    }
                  </script>



                </div>
            </div>
            <label>
              Total Price:
            </label>
            <label for="hiddenText" class="hidden-label">Hidden Label: </label>
            <span id="hiddenText"></span>

            <div class="d-flex justify-content-around align-items-center w-100 my-5">
              <input name="submit" id="submit" class="btn w-25 btn-success mx-auto" style="margin-top: -30px; margin: 0 auto" type="submit" value="Reserve Car" required />

            </div>

          </div>
        </div>
      </form>

    </div>
  </div>

  <!---script src="usingTs.js"></script--->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>