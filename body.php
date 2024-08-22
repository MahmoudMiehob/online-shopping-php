<?php
include 'db.php';

if (isset($_SESSION['uid'])) {
	$user_id = $_SESSION['uid'];
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
	$(document).ready(function () {
		// check if product is already in wishlist on page load
		$('.add-to-wishlist').each(function () {
			var pid = $(this).attr('pid');
			var user_id = '<?php echo $user_id; ?>'; // assuming you have a $user_id variable set
			var $element = $(this); // store the reference to the original element

			$.ajax({
				type: 'POST',
				url: 'wishlist_check.php', // server-side script to check if product is in wishlist
				data: { pid: pid, user_id: user_id },
				success: function (response) {
					if (response === 'true') {
						$element.find('i').css('color', 'red');
						$element.find('span').text('remove from wishlist');
					}
				}
			});
		});

		// add event listener to button click
		$('.add-to-wishlist').on('click', function () {
			var pid = $(this).attr('pid');
			var ip_add = '<?php echo $_SERVER['REMOTE_ADDR']; ?>'; // get user's IP address
			var user_id = '<?php echo $user_id; ?>'; // assuming you have a $user_id variable set
			var $i = $(this).find('i');
			var $self = $(this); // capture the original element

			$.ajax({
				type: 'POST',
				url: 'wishlist_add.php', // server-side script to add product to wishlist
				data: { pid: pid, ip_add: ip_add, user_id: user_id },
				success: function (response) {
					if (response === 'true') {
						$i.css('color', 'red'); // use the captured $i
						$self.find('span').text('remove from wishlist'); // use the captured $self
					}
				}
			});
		});

		$('.add-to-wishlist').each(function () {
			var pid = $(this).attr('pid');
			var user_id = '<?php echo $user_id; ?>'; // assuming you have a $user_id variable set
			var $i = $(this).find('i');

			$(this).on('click', function () {
				if ($i.css('color') === 'rgb(255, 0, 0)') { // check if color is already red
					$.ajax({
						type: 'POST',
						url: 'wishlist_remove.php', // server-side script to remove from wishlist
						data: { pid: pid, user_id: user_id },
						success: function (response) {
							if (response === 'true') {
								$i.css('color', ''); // reset heart icon color
								$(this).find('span').text('add to wishlist');
							}
						}
					});
				}
			});
		});
	});

</script>

<div class="main main-raised">
	<div class="container mainn-raised" style="width:100%;">

	</div>

	<!-- Left and right controls -->
	<a class="left carousel-control _26sdfg" href="#myCarousel" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control _26sdfg" href="#myCarousel" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right"></span>
		<span class="sr-only">Next</span>
	</a>
</div>
</div>



<!-- SECTION -->
<div class="section mainn mainn-raised">


	<!-- container -->
	<div class="container">

		<!-- row -->
		<div class="row">
			<!-- shop -->
			<div class="col-md-4 col-xs-6">
				<a href="product.php?p=78">
					<div class="shop">
						<div class="shop-img">
							<img src="./img/shop01.png" alt="">
						</div>
						<div class="shop-body">
							<h3>Laptop<br>Collection</h3>
							<a href="product.php?p=78" class="cta-btn">Shop now <i
									class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
				</a>
			</div>
			<!-- /shop -->

			<!-- shop -->
			<div class="col-md-4 col-xs-6">
				<a href="product.php?p=72">
					<div class="shop">
						<div class="shop-img">
							<img src="./img/shop03.png" alt="">
						</div>
						<div class="shop-body">
							<h3>Accessories<br>Collection</h3>
							<a href="product.php?p=72" class="cta-btn">Shop now <i
									class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
				</a>
			</div>
			<!-- /shop -->

			<!-- shop -->
			<div class="col-md-4 col-xs-6">
				<a href="product.php?p=79">
					<div class="shop">
						<div class="shop-img">
							<img src="./img/shop02.png" alt="">
						</div>
						<div class="shop-body">
							<h3>Cameras<br>Collection</h3>
							<a href="product.php?p=79" class="cta-btn">Shop now <i
									class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
				</a>
			</div>
			<!-- /shop -->
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->



<!-- SECTION -->
<div class="section">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">

			<!-- section title -->
			<div class="col-md-12">
				<div class="section-title">
					<h3 class="title">New Products</h3>

				</div>
			</div>
			<!-- /section title -->

			<!-- Products tab & slick -->
			<div class="col-md-12 mainn mainn-raised">
				<div class="row">
					<div class="products-tabs">
						<!-- tab -->
						<div id="tab1" class="tab-pane active">
							<div class="products-slick" data-nav="#slick-nav-1">

								<?php
								$product_query = "SELECT * 
FROM products, categories 
WHERE product_cat=cat_id 
ORDER BY product_id DESC 
LIMIT 5";

								$run_query = mysqli_query($con, $product_query);
								if (mysqli_num_rows($run_query) > 0) {

									while ($row = mysqli_fetch_array($run_query)) {
										$pro_id = $row['product_id'];
										$pro_cat = $row['product_cat'];
										$pro_brand = $row['product_brand'];
										$pro_title = $row['product_title'];
										$pro_price = $row['product_price'];
										$pro_image = $row['product_image'];

										$cat_name = $row["cat_title"];

										echo "
        
                
                <div class='product'>
                    <a href='product.php?p=$pro_id'><div class='product-img'>
                        <img src='product_images/$pro_image' style='max-height: 170px;' alt=''>
                        <div class='product-label'>
                            <span class='new'>NEW</span>
                        </div>
                    </div></a>
                    <div class='product-body'>
                        <p class='product-category'>$cat_name</p>
                        <h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
                        <h4 class='product-price header-cart-item-info'>$pro_price</h4> ";
										?>
										<div class="product-btns">

											<button pid='<?= $pro_id ?>' id='wishlist' class='add-to-wishlist'><i
													class='fa fa-heart-o'></i><span class='tooltipp'>add to
													wishlist</span></button>
										</div>
									</div>
									<div class='add-to-cart'>
										<button pid='<?= $pro_id ?> ' id='productaddtocart<?= $pro_id ?>'
											class='add-to-cart-btn block2-btn-towishlist'><i class='fa fa-shopping-cart'></i>
											add to cart</button>
									</div>

									<form id="addToCartForm<?= $pro_id ?>" action="addtocart.php" method="post">
										<input type="hidden" name="proId" value="<?= $pro_id; ?>">
										<input type="hidden" name="addToCart" value="1">
										<input type="hidden" name="qty" value="1">
									</form>

									<script>
										document.getElementById("productaddtocart<?= $pro_id ?>").addEventListener("click", function () {
											document.getElementById("addToCartForm<?= $pro_id ?>").submit();
										});
									</script>
								</div>

								<?php
									}

								}
								?>
						<!-- /product -->
					</div>
				</div>
				<!-- /tab -->
			</div>
		</div>
	</div>
	<!-- Products tab & slick -->
</div>

<!-- /row -->
</div>
<!-- /container -->
</div>
<!-- /SECTION -->



<!-- SECTION -->
<div class="section" style="color:white">
	<!-- container -->
	<div class="container">
		<!-- row -->
		<div class="row">
			<div class="col-md-4 col-xs-6">
				<div class="section-title">
					<h4 class="title">Top price</h4>
					<div class="section-nav">
						<div id="slick-nav-3" class="products-slick-nav"></div>
					</div>
				</div>


				<div class="products-widget-slick" data-nav="#slick-nav-3">


					<div id="get_product_home2">
						<!-- product widget -->
						<?php
						$product_query = "SELECT * 
								FROM products 
								ORDER BY product_price DESC 
								LIMIT 3";



						$run_query = mysqli_query($con, $product_query);
						if (mysqli_num_rows($run_query) > 0) {

							while ($row = mysqli_fetch_array($run_query)) { ?>
								<div class="product-widget">
									<a href="product.php?p=<?= $row['product_id'] ?>">
										<div class="product-img">
											<img src="product_images/<?= $row['product_image'] ?> " alt="">
										</div>
										<div class="product-body">
											<h3 class="product-name"><?= $row['product_desc'] ?></h3>
											<h4 class="product-price"><?= $row['product_price'] ?></h4>

										</div>
									</a>

								</div>
							<?php }
						} ?>

						<!-- /product widget -->

					</div>
				</div>
			</div>

			<div class="col-md-4 col-xs-6">
				<div class="section-title">
					<h4 class="title">NEW</h4>
					<div class="section-nav">
						<div id="slick-nav-4" class="products-slick-nav"></div>
					</div>
				</div>

				<div class="products-widget-slick" data-nav="#slick-nav-4">
					<div>
						<!-- product widget -->
						<?php
						$product_query = "SELECT * 
								FROM products 
								ORDER BY product_id DESC 
								LIMIT 3";



						$run_query = mysqli_query($con, $product_query);
						if (mysqli_num_rows($run_query) > 0) {

							while ($row = mysqli_fetch_array($run_query)) { ?>
								<div class="product-widget">
									<a href="product.php?p=<?= $row['product_id'] ?>">

										<div class="product-img">
											<img src="product_images/<?= $row['product_image'] ?> " alt="">
										</div>
										<div class="product-body">
											<h3 class="product-name"><?= $row['product_desc'] ?></h3>
											<h4 class="product-price"><?= $row['product_price'] ?></h4>
										</div>
									</a>

								</div>
							<?php }
						} ?>
					</div>


				</div>
			</div>


			<div class="col-md-4 col-xs-6">
				<div class="section-title">
					<h4 class="title">Top selling</h4>
					<div class="section-nav">
						<div id="slick-nav-5" class="products-slick-nav"></div>
					</div>
				</div>

				<div class="products-widget-slick" data-nav="#slick-nav-5">
					<div>
						<!-- product widget -->
						<?php
						$product_query = "SELECT * 
								FROM products 
								WHERE product_cat = 1
								ORDER BY product_id DESC 
								LIMIT 3";



						$run_query = mysqli_query($con, $product_query);
						if (mysqli_num_rows($run_query) > 0) {

							while ($row = mysqli_fetch_array($run_query)) { ?>
								<div class="product-widget">
									<a href="product.php?p=<?= $row['product_id'] ?>">
										<div class="product-img">
											<img src="product_images/<?= $row['product_image'] ?> " alt="">
										</div>
										<div class="product-body">
											<h3 class="product-name"><?= $row['product_desc'] ?></h3>
											<h4 class="product-price"><?= $row['product_price'] ?></h4>
										</div>
									</a>

								</div>
							<?php }
						} ?>
						<!-- product widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- /row -->
	</div>
	<!-- /container -->
</div>
<!-- /SECTION -->
</div>