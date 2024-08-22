<?php
include 'db.php';

if (isset($_POST["pid"]) && isset($_POST["user_id"])) {
    $pid = $_POST["pid"];
    $user_id = $_POST["user_id"];

    $query = "DELETE FROM wishlist WHERE p_id =? AND user_id =?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $pid, $user_id);
    $stmt->execute();

    echo "true";
} else {
    echo "false";
}