<?php 
if (!isset($db)) {
	$db = new DataContext();
}

$categories = $db->getCategories();
?>

<div id="right-area" class="right-area-bg">

	<h2>Danh mục sản phẩm</h2>									
	<ul class="right-area-bg" style="padding-top: 20px">
		
		<?php foreach ($categories as $category) : ?>
			<li><a href="products.php"><?php echo $category->name; ?></a></li>
		<?php endforeach; ?>

	</ul>


</div>

<div class="clearfix"></div>