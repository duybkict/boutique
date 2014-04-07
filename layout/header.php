<?php 
if (!isset($db)) {
	$db = new DataContext();
}

$categories = $db->getCategories(array('limit' => 7));
?>

<div id="color-stripes"></div>

<div id="header-wrapper">
	<div class="container">
		<div id="header-logo">
			<a href="index.php"><h1>Boutique</h1></a>
			<span>Phụ kiện, Quà tặng, Trang trí</span>
		</div>
		<div id="header-menu">
			<ul id="secondary-menu" class="nav">

				<?php foreach ($categories as $category) : ?>
					<li><a href="products.php"><?php echo $category->name; ?></a></li>
				<?php endforeach; ?>
				<li><a href="products.php">Xem tất cả</a></li>

			</ul>
		</div>
	</div>
</div>

<div class="clearfix" ></div>