<?php
ob_start();
include 'db.php';
?>


<div id="newsletter" class="section">
	<div class="container">
		<div class="row ">
			<div class="col-md-12">
				<div class="newsletter">
					<p>Sign Up for the <strong>OFFERUPDATES</strong></p>
					<form class="mx-auto" style="max-width: 600px;" method="post">
						<input type="email" class="input  border-white" placeholder="Your Email" name="email">
						<button class="newsletter-btn" name="submit" type="submit">Sign Up</button>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
	if(isset($_POST["email"])){
		$email = $_POST["email"];
	}
	// Check if email exists in users table
	$query = "SELECT * FROM user_info WHERE email = '$email'";
	$result = $con->query($query);

	if ($result->num_rows > 0) {
		// Check if email is already subscribed
		$row = $result->fetch_assoc();
		if ($row['subscribe'] == 1) {
			$message = "You are already subscribed!";
			$alert_class = "alert-info";
		} else {
			// Update subscribe column to 1
			$query = "UPDATE user_info SET subscribe = 1 WHERE email = '$email'";
			$con->query($query);
			$message = "Thank you for subscribing!";
			$alert_class = "alert-success";
		}
	} else {
		$message = "Please register on our website to subscribe.";
		$alert_class = "alert-danger";
	}
}
?>

<!-- Modal -->
<div class="modal fade" id="myModalOFFERUPDATES" tabindex="-1" aria-labelledby="exampleModalLabelOFFERUPDATES" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabelOFFERUPDATES">Subscription Status</h5>
				
			</div>
			<div class="modal-body">
				<div class="alert <?php echo $alert_class ?? ''; ?>" role="alert">
					<?php echo $message ?? ''; ?>
					<button type="button" class="close bull-right" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons"></i>close
                </button>
				</div>
				
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<!-- Trigger the modal only when form is submitted -->
<?php if ($_SERVER["REQUEST_METHOD"] == "POST") { ?>
	<script>
   $(document).ready(function () {
        $('#myModalOFFERUPDATES').modal('show');
        setTimeout(function () {
            $('#myModalOFFERUPDATES').modal('hide');
        }, 3000); // 3000 milliseconds = 3 seconds
    });

</script>
<?php } ?>