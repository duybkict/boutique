<?php
include_once './core/DataContext.php';

$title_for_layout = 'Danh sách sản phẩm | Boutique';
$db = new DataContext();
$products = $db->getProducts();
?>

<html>
	<?php include './layout/documents.php'; ?>

	<body>
		<?php include './layout/header.php'; ?>

		<div class="container">
			<div id="content">
				<div id="main-bg">
					<div id="main-bottom-bg">
						
						<!-- MAIN CONTENT -->
						<div id="left-area">
							<h1>Văn phòng phẩm</h1>

							<?php
							foreach ($products as $i => $product) :
								if (($i + 1) % 4 == 0) echo '<div class="row row-product">';
							?>
								<div class="cell-product col-xs-3">
									<div class="main-item">
										<a href="#">
											<img class="thumb" src="<?php echo $product->image; ?>" />
											<span class="price-tag"><?php echo $product->price; ?>k</span>
										</a>
										<h3><a href="#"><?php echo $product->name; ?></a></h3>
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