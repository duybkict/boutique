<?php

include_once 'Product.php';
include_once 'Category.php';

class DataContext {

	private $host = 'localhost';
	private $user = 'root';
	private $password = '';
	private $database = 'boutique';
	public $defaultLimit = 8;

	private function getConnection()
	{
		$db = new mysqli($this->host, $this->user, $this->password, $this->database);
		$db->set_charset('utf8');
		if ($db->connect_errno > 0) {
			die('Unable to connect to database [' . $db->connect_error . ']');
		}

		return $db;
	}

	public function getProducts($options = array())
	{
		$db = $this->getConnection();

		$defaults = array(
			/*'page' => null,*/
			'limit' => $this->defaultLimit,
			'offset' => 0,
			'search' => '',
			'published' => 1,
			'category_id' => '%'
		);
		$options = array_merge($defaults, $options);
				
		if (isset($options['page'])) {
			$limit = $this->defaultLimit;
			$offset = ($options['page'] - 1) * $this->defaultLimit;
		} else {
			$limit = $options['limit'];
			$offset = $options['offset'];
		}
		$search = '%' . $options['search'] . '%';
		$published = $options['published'];
		if (is_array($published)) {
			$published = implode(',', $published);
		}
		$categoryId = $options['category_id'];
		if (is_array($categoryId)) {
			$categoryId = implode(',', $categoryId);
		}

		$statement = $db->prepare(
				"SELECT * FROM `products`
			WHERE (`published` IN (?) OR `published` LIKE ?)
			AND (`category_id` IN (?) OR `category_id` LIKE ?)
			AND (`name` LIKE ? OR `description` LIKE ? OR `short_description` LIKE ?)
			ORDER BY `published_date` DESC
			LIMIT ? OFFSET ?");
		$statement->bind_param('sssssssii', $published, $published, $categoryId, $categoryId, $search, $search, $search, $limit, $offset);
		$statement->execute();

		$products = array();
		$product = new Product();
		$statement->bind_result($product->id, $product->name, $product->shortDescription, $product->description, $product->image, $product->categoryId, $product->price, $product->published, $product->publishedDate, $product->createdDate, $product->modifiedDate);
		while ($statement->fetch()) {
			$products[] = unserialize(serialize($product));
		}

		$statement->close();
		$db->close();

		return $products;
	}

	public function getCountProducts($options = array())
	{
		unset($options['page']);
		$options['offset'] = 0;
		$options['limit'] = PHP_INT_MAX;
		return count($this->getProducts($options));
	}

	public function getPageCountProducts($options = array())
	{
		return (int) ceil($this->getCountProducts($options) / $this->defaultLimit);
	}

	public function getCategories($options = array())
	{
		$db = $this->getConnection();

		$defaults = array(
			'limit' => $this->defaultLimit,
			'offset' => 0,
			'search' => '',
		);
		$options = array_merge($defaults, $options);

		$limit = $options['limit'];
		$offset = $options['offset'];
		$search = '%' . $options['search'] . '%';

		$statement = $db->prepare(
				"SELECT * FROM `categories` 
				WHERE `name` LIKE ?
				LIMIT ? OFFSET ?");
		$statement->bind_param('sii', $search, $limit, $offset);
		$statement->execute();

		$categories = array();
		$category = new Category();
		$statement->bind_result($category->id, $category->name, $category->createdDate, $category->modifiedDate);
		while ($statement->fetch()) {
			$categories[] = unserialize(serialize($category));
		}

		$statement->close();
		$db->close();

		return $categories;
	}

	public function getCategoryById($id)
	{
		$db = $this->getConnection();

		$statement = $db->prepare(
				"SELECT * FROM `categories` 
				WHERE `id` = ?
				LIMIT 1 OFFSET 0");
		$statement->bind_param('i', $id);
		$statement->execute();

		$category = new Category();
		$statement->bind_result($category->id, $category->name, $category->createdDate, $category->modifiedDate);
		if (!$statement->fetch()) {
			$category = null;
		}

		$statement->close();
		$db->close();

		return $category;
	}

}
