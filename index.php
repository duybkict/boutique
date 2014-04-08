<?php
include_once './core/DataContext.php';

$title_for_layout = 'Boutique | Cửa hàng phụ kiện, quà tặng, trang trí';
$db = new DataContext();
$products = $db->getProducts(array('limit' => 12));
?>

<html>
	<?php include './layout/documents.php'; ?>

	<body>
		<?php include './layout/header.php'; ?>

		<?php include './layout/slides.php'; ?>

		<?php include './layout/featured.php'; ?>

		<div class="container">
			<div id="content">
				<div id="main-bg">
					<div id="main-bottom-bg">
						
						<!-- MAIN CONTENT -->
						<div id="left-area">
							<h3 class="offer-title">
								<span>Sản phẩm mới</span>
							</h3>						
							<div style="height:63px;"></div>
							
							<?php
							foreach ($products as $i => $p) :
								if (($i + 1) % 4 == 0) echo '<div class="row row-product">';
							?>
								<div class="cell-product col-xs-3">
									<div class="main-item">
										<a href="#">
											<img class="thumb" src="<?php echo $p->image; ?>" />
											<span class="price-tag"><?php echo $p->price; ?>k</span>
										</a>
										<h3><a href="#"><?php echo $p->name; ?></a></h3>
									</div>
								</div>
							<?php
								if (($i + 1) % 4 == 0) echo '</div>';
							endforeach;
							?>

						</div>
						<!--/ MAIN CONTENT -->
						
						<?php include './layout/sidebar.php'; ?>

					</div>
				</div>
			</div>
		</div>

		<?php include './layout/footer.php'; ?>
	</body>
</html>