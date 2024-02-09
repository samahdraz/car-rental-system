<?php
$plate = $_POST['plate'];
$country = $_POST['car_country'];
$Model = $_POST['Model'];
$price = $_POST['price'];
$manual = $_POST['type'];
$color = $_POST['color'];
$office = $_POST['office_country'];
$detail = $_POST['detail'];
if($manual==="manual"){
	$type="manual";
}
else{
	$type="automatic";
}


$conn = mysqli_connect("localhost", "root", "", "car rental system");

if (!$conn) {
  die("Connection failed!");
}

//check if form submitted
if (isset($_POST['submit']))
{
   $img_name = $_FILES['glryimage']['name'];
   echo "$img_name";
   //upload file
   if ($img_name!='')
   {
       $ext = pathinfo($img_name, PATHINFO_EXTENSION);
       $allowed = ['png', 'gif', 'jpg', 'jpeg'];

       //check if it is valid image type
       if (in_array($ext, $allowed))
       {   $stmt = $conn->prepare("SELECT office_id FROM office WHERE country='$office'");
          $stmt->execute();
           $result = $stmt->get_result(); 
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $office=$row["office_id"];  
           $img_data = addslashes(file_get_contents($_FILES['glryimage']['tmp_name']));
           // insert image into mysql database
           $sql = "INSERT into Car(plate_id,price, country, model,type,color,detail,image,office_id) values('$plate','$price', '$country', '$Model','$type','$color','$detail','$img_data','$office')";
           mysqli_query($conn, $sql) or die("Error " . mysqli_error($conn)); // Use $conn instead of $con
           include("addcar.html");}
           else{
            echo "No office in that country";
        }

       }
       else
       {
           header("Location: ttl.php?st=error");
       }
   }
   else
       header("Location: ttl.php");
}

?>