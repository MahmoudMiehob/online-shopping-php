<?php
include "header.php";
include 'db.php';

	
if(isset($_SESSION['uid'] )){
	$user_id = $_SESSION['uid'] ;
}

?>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
		$(document).ready(function() {
			// check if product is already in wishlist on page load
			$('.add-to-wishlist').each(function() {
			var pid = $(this).attr('pid');
			var user_id = '<?php echo $user_id; ?>'; // assuming you have a $user_id variable set
			var $element = $(this); // store the reference to the original element

			$.ajax({
				type: 'POST',
				url: 'wishlist_check.php', // server-side script to check if product is in wishlist
				data: { pid: pid, user_id: user_id },
				success: function(response) {
				if (response === 'true') {
					$element.find('i').css('color', 'red');
				}
				}
			});
			});

			// add event listener to button click
			$('.add-to-wishlist').on('click', function() {
				var pid = $(this).attr('pid');
				var ip_add = '<?php echo $_SERVER['REMOTE_ADDR']; ?>'; // get user's IP address
				var user_id = '<?php echo $user_id; ?>'; // assuming you have a $user_id variable set
				var $i = $(this).find('i');
				var $self = $(this); // capture the original element

				$.ajax({
					type: 'POST',
					url: 'wishlist_add.php', // server-side script to add product to wishlist
					data: { pid: pid, ip_add: ip_add, user_id: user_id },
					success: function(response) {
						if (response === 'true') {
							$i.css('color', 'red'); // use the captured $i
						}
					}
				});
			});

			$('.add-to-wishlist').each(function() {
				var pid = $(this).attr('pid');
				var user_id = '<?php echo $user_id; ?>'; // assuming you have a $user_id variable set
				var $i = $(this).find('i');

				$(this).on('click', function() {
					if ($i.css('color') === 'rgb(255, 0, 0)') { // check if color is already red
						$.ajax({
							type: 'POST',
							url: 'wishlist_remove.php', // server-side script to remove from wishlist
							data: { pid: pid, user_id: user_id },
							success: function(response) {
								if (response === 'true') {
									$i.css('color', ''); // reset heart icon color
								}
							}
						});
					}
				});
			});
});

	</script>

		<!-- /BREADCRUMB -->
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
</script>
		<script>
    
    (function (global) {
	if(typeof (global) === "undefined")
	{
		throw new Error("window is undefined");
	}
    var _hash = "!";
    var noBackPlease = function () {
        global.location.href += "#";
		// making sure we have the fruit available for juice....
		// 50 milliseconds for just once do not cost much (^__^)
        global.setTimeout(function () {
            global.location.href += "!";
        }, 50);
    };	
	// Earlier we had setInerval here....
    global.onhashchange = function () {
        if (global.location.hash !== _hash) {
            global.location.hash = _hash;
        }
    };
    global.onload = function () {        
		noBackPlease();
		// disables backspace on page except on input fields and textarea..
		document.body.onkeydown = function (e) {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                e.preventDefault();
            }
            // stopping event bubbling up the DOM tree..
            e.stopPropagation();
        };		
    };
})(window);
</script>

		<!-- SECTION -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Product main img -->
					
					<?php 
								$product_id = $_GET['p'];
								
								$sql = " SELECT * FROM products AS P,categories AS C WHERE P.product_cat = C.cat_id  AND P.product_id = '$product_id'";
								if (!$con) {
									die("Connection failed: " . mysqli_connect_error());
								}
								$result = mysqli_query($con, $sql);
								if (mysqli_num_rows($result) > 0) 
								{
									while($row = mysqli_fetch_assoc($result)) 
									{
									echo '
                                <div class="col-md-5 col-md-push-2">
                                <div id="product-main-img">
                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>
                                </div>
                            </div>
                                
                                <div class="col-md-2  col-md-pull-5">
                                <div id="product-imgs">
                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                </div>
                            </div>

                                 
									';
                                    
									?>
									<!-- FlexSlider -->
									
									<?php 
									echo '
									
                                    
                                   
							<div class="col-md-5">
								<div class="product-details">
									<h2 class="product-name">'.$row['product_title'].'</h2>
									<div id = "rating_reviews">
										
									</div>
									<div>
										<h3 class="product-price">$'.$row['product_price'].'</h3>
										<span class="product-available">In Stock</span>
									</div>
									<p>'.$row['product_desc'].'</p> '?>


									<div class='add-to-cart'>
										<button pid='<?= $row['product_id']?> ' id='productaddtocart' class='add-to-cart-btn block2-btn-towishlist'
											><i class='fa fa-shopping-cart'></i> add to cart</button>
									</div>

									
									<form id="addToCartForm" action="addtocart.php" method="post">
										<input type="hidden" name="proId" value="<?= $row['product_id']; ?>">
										<input type="hidden" name="addToCart" value="1">
										<input type="hidden" name="qty" value="1">
									</form>

									<script>
										document.getElementById("productaddtocart").addEventListener("click", function() {
											document.getElementById("addToCartForm").submit();
										});
									</script>

									<?php echo '



									<ul class="product-btns">
										<li>' ?>
										<button pid='<?= $row['product_id'] ?>' id='wishlist' class='add-to-wishlist'><i class='fa fa-heart-o'></i></button>
										<?php echo '
										</li>
									</ul>

									<ul class="product-links">
										<li>Category:</li>
										<li><a href="#">'.$row["cat_title"].'</a></li>
									</ul>

									

								</div>
							</div>
							';
							$_SESSION['product_id'] = $row['product_id'];
							}
						} 
						?>		
					
					
					
					<!-- /product tab -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
                    
					<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="title">Related Products</h3>
							
						</div>
					</div>
                    
								<?php
								$product_id = $_GET['p'];
                    
					$product_query = "SELECT * FROM products,categories WHERE product_cat=cat_id AND product_id BETWEEN $product_id AND $product_id+3";
                $run_query = mysqli_query($con,$product_query);
                if(mysqli_num_rows($run_query) > 0){

                    while($row = mysqli_fetch_array($run_query)){
                        $pro_id    = $row['product_id'];
                        $pro_cat   = $row['product_cat'];
                        $pro_brand = $row['product_brand'];
                        $pro_title = $row['product_title'];
                        $pro_price = $row['product_price'];
                        $pro_image = $row['product_image'];

                        $cat_name = $row["cat_title"];

                        echo "
				
                        
                                <div class='col-md-3 col-xs-6'>
								<a href='product.php?p=$pro_id'><div class='product'>
									<div class='product-img'>
										<img src='product_images/$pro_image' style='max-height: 170px;' alt=''>
										
									</div></a>
									<div class='product-body'>
										<p class='product-category'>$cat_name</p>
										<h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
										<h4 class='product-price header-cart-item-info'>$pro_price</h4>
										
										<div class='product-btns'>
											<button pid='$pro_id' id='wishlist' class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
										</div>
									</div>
								</div>
                                </div>
							
                        
			";
		}
        ;
      
}
?>
					<!-- product -->
					
					<!-- /product -->

				</div>
				<!-- /row -->
                
			</div>
			<!-- /container -->
		</div>
		<!-- /Section -->

		<!-- FOOTER -->
<?php
include "newslettter.php";
include "footer.php";

?>
