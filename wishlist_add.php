<?php

include 'db.php';


$pid = $_POST['pid'];
$ip_add = $_POST['ip_add'];
$user_id = $_POST['user_id'];

// Check if product is already in wishlist for this user
$sql_check = "SELECT * FROM wishlist WHERE p_id = '$pid' AND user_id = '$user_id'";
$result_check = mysqli_query($con, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    // Product is already in wishlist, do nothing
    echo "<script>alert('Product is already added into the wishlist. Continue Shopping..!');</script>";
} else {
    // Insert into wishlist table
    $sql = "INSERT INTO wishlist (p_id, ip_add, user_id) VALUES ('$pid', '$ip_add', '$user_id')";
    if (mysqli_query($con, $sql)) {
        echo "true";
    } else {
        echo "false";
    }
}
?>
