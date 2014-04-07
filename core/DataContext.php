<?php

include_once 'Product.php';
include_once 'Category.php';

class DataContext {

	private $host = 'localhost';
	private $user = 'root';
	private $password = '';
	private $database = 'boutique';

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
			'limit' => 12,
			'offset' => 0,
			'search' => '',
			'published' => 1
		);		
		$options = array_merge($defaults, $options);
		
		$limit = $options['limit'];
		$offset = $options['offset'];
		$search = '%'.$options['search'].'%';
		$published = $options['published'];
		if (is_array($published)) {
			$published = implode(',', $published);
		}
		
		$statement = $db->prepare(
			"SELECT * FROM `products`
			WHERE `published` IN (?) AND (`name` LIKE ? OR `description` LIKE ? OR `short_description` LIKE ?)
			ORDER BY `published_date` DESC
			LIMIT ? OFFSET ?");
		$statement->bind_param('ssssii', $published, $search, $search, $search, $limit, $offset);
		$statement->execute();

		$products = array();
		$product = new Product();
		$statement->bind_result($product->id, $product->name, $product->shortDescription, $product->description, $product->image, $product->categoryId, $product->price, $product->published, $product->publishedDate, $product->createdDate, $product->modifiedDate);
		while ($statement->fetch()) {
			$products[] =  unserialize(serialize($product));
		}

		$statement->close();
		return $products;
	}

	public function getCategories($options = array())
	{
		$db = $this->getConnection();

		$defaults = array(
			'limit' => 12,
			'offset' => 0,
			'search' => '',
		);		
		$options = array_merge($defaults, $options);
		
		$limit = $options['limit'];
		$offset = $options['offset'];
		$search = '%'.$options['search'].'%';
		
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
		return $categories;
	}
	
	public function getCategoryById($id) 
	{
		
	}

}
