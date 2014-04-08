<?php
include_once './core/DataContext.php';

$db = new DataContext();

$options = array();

if (isset($_GET['category'])) {
	$categoryId = $_GET['category'];

	$options['category_id'] = $categoryId;

	$category = $db->getCategoryById($categoryId);
	if ($category == null) {
		header('Location: products.php');
	}
}

$page = $_GET['page'];
$options['page'] = $page;
$products = $db->getProducts($options);
$pageCount = $db->getPageCountProducts($options);

$page = max(min($pageCount, $page), 1);

$title_for_layout = 'Danh sách sản phẩm | Boutique';
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
							<?php
							if (isset($category)) {
								echo "<h1>$category->name</h1>";
							} else {
								echo '<h1>Tất cả sản phẩm</h1>';
							}
							?>

							<?php
							if (empty($products))
								echo 'Không có sản phẩm nào';
							?>

							<?php
							foreach ($products as $i => $p) :
								if (($i + 1) % 4 == 0)
									echo '<div class="row row-product">';
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
								if (($i + 1) % 4 == 0)
									echo '</div>';
							endforeach;
							?>
							
							<?php if (!empty($products) && $pageCount > 1) : ?>
							<div class="clearfix"></div>
							
							<ul class="pager text-right">
								<li class="previous <?php echo ($page <= 1) ? 'disabled' : '';?>" >
									<a href="products.php?<?php echo isset($categoryId) ? "category=$categoryId" : '';?>&page=<?php echo $page - 1; ?>">
										&laquo; Trang trước
									</a>
								</li>
								<li class="next <?php echo ($page >= $pageCount) ? 'disabled' : '';?>" >
									<a href="products.php?<?php echo isset($categoryId) ? "category=$categoryId" : '';?>&page=<?php echo $page + 1; ?>">
										Trang sau &raquo;
									</a>
								</li>
							</ul>
							<?php endif; ?>

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