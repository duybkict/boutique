/*!40101 SET NAMES utf8 */;

DROP DATABASE IF EXISTS boutique; 
CREATE DATABASE boutique;
USE boutique;

CREATE TABLE categories (
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(512) NOT NULL,
	created_date DATETIME,
	modified_date DATETIME
)  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE products (
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(512) NOT NULL,
	short_description VARCHAR(1024) NOT NULL,
	description TEXT NOT NULL,
	image VARCHAR(512),
	category_id INT REFERENCES categories(id),
	price float,
	published BIT NOT NULL DEFAULT 1,
	published_date DATETIME,
	created_date DATETIME,
	modified_date DATETIME
)  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE orders (
	id INT PRIMARY KEY AUTO_INCREMENT,
	fullname VARCHAR(512) NOT NULL,
	email VARCHAR(512) NOT NULL,
	telephone VARCHAR(512) NOT NULL,
	status INT DEFAULT 1, -- 1: pending, 2: confirmed, 3: canceled
	created_date DATETIME,
	modified_date DATETIME
)  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE users (
	id INT PRIMARY KEY AUTO_INCREMENT,
	email VARCHAR(512) NOT NULL,
	password VARCHAR(512) NOT NULL,
	created_date DATETIME,
	modified_date DATETIME
)  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE order_items (
	item_id INT,
	order_id INT,
	quantity INT,
	price float
)  DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TRIGGER IF EXISTS tgg_insert_categories;
delimiter //
CREATE TRIGGER tgg_insert_categories
BEFORE INSERT ON categories
FOR EACH ROW 
BEGIN
	SET NEW.created_date = now();
	SET NEW.modified_date = now();
END;//
delimiter ;

DROP TRIGGER IF EXISTS tgg_update_categories;
delimiter //
CREATE TRIGGER tgg_update_categories
BEFORE UPDATE ON categories
FOR EACH ROW 
BEGIN
	SET NEW.modified_date = now();
END;//
delimiter ;

DROP TRIGGER IF EXISTS tgg_insert_products;
delimiter //
CREATE TRIGGER tgg_insert_products 
BEFORE INSERT ON products
FOR EACH ROW 
BEGIN
	SET NEW.created_date = now();
	SET NEW.modified_date = now();
	IF NEW.published = 1 THEN
		SET NEW.published_date = now();
	END IF;
END;//
delimiter ;

DROP TRIGGER IF EXISTS tgg_update_products;
delimiter //
CREATE TRIGGER tgg_update_products 
BEFORE UPDATE ON products
FOR EACH ROW 
BEGIN
	SET NEW.modified_date = now();
	IF NEW.published != OLD.published AND NEW.published = 1 THEN
		SET NEW.published_date = now();
	END IF;
END;//
delimiter ;

DROP TRIGGER IF EXISTS tgg_insert_orders;
delimiter //
CREATE TRIGGER tgg_insert_orders
BEFORE INSERT ON orders
FOR EACH ROW 
BEGIN
	SET NEW.created_date = now();
	SET NEW.modified_date = now();
END;//
delimiter ;

DROP TRIGGER IF EXISTS tgg_update_orders;
delimiter //
CREATE TRIGGER tgg_update_orders
BEFORE UPDATE ON orders
FOR EACH ROW 
BEGIN
	SET NEW.modified_date = now();
END;//
delimiter ;

DROP TRIGGER IF EXISTS tgg_insert_users;
delimiter //
CREATE TRIGGER tgg_insert_users
BEFORE INSERT ON users
FOR EACH ROW 
BEGIN
	SET NEW.created_date = now();
	SET NEW.modified_date = now();
END;//
delimiter ;

DROP TRIGGER IF EXISTS tgg_update_users;
delimiter //
CREATE TRIGGER tgg_update_users
BEFORE UPDATE ON users
FOR EACH ROW 
BEGIN
	SET NEW.modified_date = now();
END;//
delimiter ;

INSERT INTO categories(name) VALUES ('Nội thất');
INSERT INTO categories(name) VALUES ('Mô hình');
INSERT INTO categories(name) VALUES ('Văn phòng phẩm');
INSERT INTO categories(name) VALUES ('Phụ kiện');
INSERT INTO categories(name) VALUES ('Thủy tinh & Gốm sứ');
INSERT INTO categories(name) VALUES ('Manga & Anime');
INSERT INTO categories(name) VALUES ('Sản phẩm cá nhân');
-- SELECT * FROM categories

-- 1
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Dụng cụ văn phòng', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/1.jpg', 
		3, 60);
-- 2
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Khăn tắm', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/2.jpg', 
		7, 30);
-- 3
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Túi #1', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/3.jpg', 
		4, 300);
-- 4
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Túi #2', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/4.jpg', 
		4, 650);
-- 5
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Túi #3', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/5.jpg', 
		4, 800);
-- 6
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Túi #4', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/6.jpg', 
		4, 400);
-- 7
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Túi #5', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/7.jpg', 
		4, 1200);
-- 8
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Balo #1', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/8.jpg', 
		4, 300);
-- 9
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Balo #2', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/9.jpg', 
		4, 570);
-- 10
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Balo #3', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/10.jpg', 
		4, 230);
-- 11
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Balo #4', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/11.jpg', 
		4, 900);
-- 12
INSERT INTO products(name, short_description, description, image, category_id, price) 
VALUES ('Cốc sứ', 
		'Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. ', 
		'<p>Ut lacinia dolor sed diam auctor sodales. Morbi dapibus suscipit laoreet. Quisque bibendum iaculis augue tempus posuere. </p>', 
		'img/products/12.png', 
		5, 50);
-- SELECT * FROM products