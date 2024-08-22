<?php
include 'header.php';
if(isset($_GET['cat_id'])){
$cat_id = $_GET['cat_id'];}

?>
    
	<div class="main main-raised"> 
        
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					

					<!-- STORE -->
					<div id="store" class="col-md-12">
						<!-- store top filter -->
						<div class="store-filter clearfix">
							
							
						</div>
						<!-- /store top filter -->

						<!-- store products -->
						<div class="row" id="product-row">
						<div class="col-md-12 col-xs-12" id="product_msg">
					</div>
							<!-- product -->
							<div id="get_product" cid=<?php echo "$cat_id"; ?>>
							<!--Here we get product jquery Ajax Request-->
						</div>
							
							<!-- /product -->
						</div>
						<!-- /store products -->

						<!-- store bottom filter -->
						<div class="store-filter clearfix">
							<ul class="store-pagination" id="pageno" cid=<?php echo "$cat_id"; ?>>
								<li ><a class="active" href="#aside">1</a></li>
								
								<li><a href="#"><i class="fa fa-angle-right"></i></a></li>
							</ul>
						</div>
						<!-- /store bottom filter -->
					</div>
					<!-- /STORE -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
</div>
<?php
include "newslettter.php";
include "footer.php";
?>