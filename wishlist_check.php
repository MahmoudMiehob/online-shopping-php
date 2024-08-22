<?php
include 'db.php';

// get the posted data
$pid = $_POST['pid'];
$user_id = $_POST['user_id'];

// check if product is already in wishlist
$sql = "SELECT * FROM wishlist WHERE p_id = '$pid' AND user_id = '$user_id'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
  echo 'true';
} else {
  echo 'false';
}

?>