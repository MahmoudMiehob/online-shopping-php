<?php

include 'db.php';
session_start();

if(isset($_POST["addToCart"])){
		

		$p_id = $_POST["proId"];
		

		if (isset($_SESSION["uid"])) {
			$user_id = $_SESSION["uid"];
			$ip_add = $_SERVER['REMOTE_ADDR']; // define $ip_add
	
			$sql = "SELECT * FROM cart WHERE p_id = ? AND user_id = ?";
			$stmt = mysqli_prepare($con, $sql);
			mysqli_stmt_bind_param($stmt, "ii", $p_id, $user_id);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			$count = mysqli_num_rows($result);
	
			if ($count > 0) {
				echo "<script>
				setTimeout(function(){
					alert('Product is already added into the cart. Continue Shopping..!');
					window.location.href = '".$_SERVER['HTTP_REFERER']."';
				});
			</script>";	
		
		} else {
				$sql = "INSERT INTO cart (p_id, ip_add, user_id, qty) VALUES (?, ?, ?, ?)";
				$stmt = mysqli_prepare($con, $sql);
				$qty = 1;
				mysqli_stmt_bind_param($stmt, "isii", $p_id, $ip_add, $user_id, $qty);

				if (mysqli_stmt_execute($stmt)) {
					$sql = "DELETE FROM wishlist WHERE p_id = ? AND user_id = ?";
					$stmt = mysqli_prepare($con, $sql);
					mysqli_stmt_bind_param($stmt, "ii", $p_id, $user_id);
					if (mysqli_stmt_execute($stmt)) {
						header("Location: cart.php");
						exit;
					} else {
						echo "Error deleting from wishlist: " . mysqli_error($con);
					}
				} else {
					echo "Error inserting into cart: " . mysqli_error($con);
				}
			}
		}else{
			$sql = "SELECT id FROM cart WHERE ip_add = '$ip_add' AND p_id = '$p_id' AND user_id = -1";
			$query = mysqli_query($con,$sql);
			if (mysqli_num_rows($query) > 0) {
				echo "<script>
				setTimeout(function(){
					alert('Product is already added into the cart. Continue Shopping..!');
					window.location.href = '".$_SERVER['HTTP_REFERER']."';
				});
			</script>";	
					exit();
			}
			$sql = "INSERT INTO `cart`
			(`p_id`, `ip_add`, `user_id`, `qty`) 
			VALUES ('$p_id','$ip_add','-1','1')";
			if (mysqli_query($con,$sql)) {
				
				$sql = "DELETE FROM wishlist WHERE p_id = '$p_id' AND ip_add = '$ip_add'";

				if(mysqli_query($con,$sql)){
					header ("Location: cart.php");
					exit();
				}
			}
			
		}
		
	}