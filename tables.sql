SET foreign_key_checks = 0;

drop table if exists users_customer,users_owner,addresses,restaurants,users,regions,menu_items,menus,promotions,orders
,cart,restaurant_regions,restaurant_feedbacks,promotion_items,order_items,cart_items,restaurant_addresses,notifications;

SET foreign_key_checks = 1;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

SET foreign_key_checks = 0;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: aba
--

-- --------------------------------------------------------

--
-- Table structure for table addresses
--

CREATE TABLE IF NOT EXISTS addresses (
  user_id int(11) NOT NULL,
  door_number int(11) NOT NULL,
  street varchar(225) DEFAULT NULL,
  district varchar(225) DEFAULT NULL,
  city varchar(225) DEFAULT NULL,
  PRIMARY KEY (user_id)
)  DEFAULT CHARSET=utf8;

--
-- Dumping data for table addresses
--

INSERT INTO addresses (user_id, door_number, street, district, city) VALUES
(1, 22, 'dasd', 'Sariyer', 'Istanbul'),
(2, 88, '99', '99', '99'),
(3, 4234, 'dfsdf', 'sdf', 'sdfsdf');

-- --------------------------------------------------------

--
-- Table structure for table cart
--

CREATE TABLE IF NOT EXISTS cart (
  cart_id int(11) NOT NULL AUTO_INCREMENT,
  customer_id int(11) NOT NULL,
  restaurant_id int(11) NOT NULL,
  total decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (cart_id),
  KEY customer_id (customer_id),
  KEY restaurant_id (restaurant_id)
)   DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table cart
--


-- --------------------------------------------------------

--
-- Table structure for table cart_items
--

CREATE TABLE IF NOT EXISTS cart_items (
  cart_id int(11) NOT NULL,
  item_id int(11) NOT NULL,
  KEY cart_id (cart_id),
  KEY item_id (item_id)
)  DEFAULT CHARSET=utf8;

--
-- Dumping data for table cart_items
--


-- --------------------------------------------------------

--
-- Table structure for table menus
--

CREATE TABLE IF NOT EXISTS menus (
  restaurant_id int(11) NOT NULL,
  menu_id int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (menu_id),
  KEY restaurant_id (restaurant_id)
)   DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table menus
--

INSERT INTO menus (restaurant_id, menu_id) VALUES
(1, 1),
(5, 5),
(6, 6),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table menu_items
--

CREATE TABLE IF NOT EXISTS menu_items (
  item_id int(11) NOT NULL AUTO_INCREMENT,
  menu_id int(11) NOT NULL,
  name varchar(225) DEFAULT NULL,
  type varchar(225) DEFAULT NULL,
  istatus int(1) NOT NULL DEFAULT '1',
  price decimal(4,2) DEFAULT NULL,
  hit int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (item_id),
  KEY menu_id (menu_id)
)   DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table menu_items
--

INSERT INTO menu_items (item_id, menu_id, name, type, istatus, price, hit) VALUES
(9, 1, '123', 'Appetizer', 0, 10.00, 0),
(6, 1, 'Baklava', 'Dessert', 1, 40.40, 23),
(5, 1, 'Lahmacun', 'Main', 1, 3.50, 0),
(16, 0, 'Soup', 'Soup', 1, 5.99, 0),
(12, 1, 'Coca Cola', 'Drink', 1, 2.25, 0),
(13, 1, 'Mercimek', 'Soup', 1, 5.99, 0),
(14, 1, 'Duck with Orange Souce', 'Main', 1, 99.99, 0),
(15, 5, 'Iskembe', 'Soup', 1, 12.00, 0),
(17, 6, 'Iskembe', 'Drink', 1, 40.00, 0),
(18, 7, 'Adana', 'Main', 1, 17.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table notifications
--

CREATE TABLE IF NOT EXISTS notifications (
  n_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  message text,
  nstatus int(11) DEFAULT '0',
  PRIMARY KEY (n_id)
)   DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table notifications
--

INSERT INTO notifications (n_id, user_id, message, nstatus) VALUES
(1, 0, 'Your order from  at 14 May 2016 15:14 has been approved.', 0),
(11, 1, 'Your order from <strong>Oz Zonguldak Restaurant</strong> at <strong>14 May 2016 13:18</strong> has been delivered.', 0),
(10, 1, 'Your order from <strong>Oz Zonguldak Restaurant</strong> at <strong>14 May 2016 13:22</strong> has been delivered.', 0);

-- --------------------------------------------------------

--
-- Table structure for table orders
--

CREATE TABLE IF NOT EXISTS orders (
  order_id int(11) NOT NULL AUTO_INCREMENT,
  customer_id int(11) NOT NULL,
  restaurant_id int(11) NOT NULL,
  price decimal(8,2) DEFAULT NULL,
  ostatus int(1) NOT NULL DEFAULT '1',
  order_date datetime DEFAULT NULL,
  delivery_date datetime DEFAULT NULL,
  PRIMARY KEY (order_id),
  KEY restaurant_id (restaurant_id),
  KEY customer_id (customer_id)
)   DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table orders
--

INSERT INTO orders (order_id, customer_id, restaurant_id, price, ostatus, order_date, delivery_date) VALUES
(1, 1, 1, 323.20, 1, '2016-01-14 13:08:57', '2016-05-15 10:00:00'),
(2, 1, 1, 323.20, 1, '2016-01-14 13:14:10', '2016-05-15 10:00:00'),
(3, 1, 1, 0.00, 1, '2016-01-14 13:15:07', '2016-05-15 10:00:00'),
(4, 1, 1, 35.94, 1, '2016-04-24 13:16:04', '2016-05-15 08:15:00'),
(5, 1, 1, 35.94, 4, '2016-05-14 13:18:37', '2016-05-15 06:30:00'),
(6, 1, 1, 99.99, 4, '2016-05-14 13:22:01', '2016-05-15 06:30:00'),
(7, 1, 1, 404.00, 1, '2016-05-14 16:11:05', '2016-05-15 06:30:00');

-- --------------------------------------------------------

--
-- Table structure for table order_items
--

CREATE TABLE IF NOT EXISTS order_items (
  order_id int(11) NOT NULL,
  item_id int(11) NOT NULL,
  KEY order_id (order_id),
  KEY item_id (item_id)
)  DEFAULT CHARSET=utf8;

--
-- Dumping data for table order_items
--

INSERT INTO order_items (order_id, item_id) VALUES
(4, 13),
(4, 13),
(4, 13),
(4, 13),
(4, 13),
(4, 13),
(5, 13),
(5, 13),
(5, 13),
(5, 13),
(5, 13),
(7, 6),
(7, 6),
(5, 13),
(6, 14),
(7, 6),
(7, 6),
(7, 6),
(7, 6),
(7, 6),
(7, 6),
(7, 6),
(7, 6);

-- --------------------------------------------------------

--
-- Table structure for table promotions
--

CREATE TABLE IF NOT EXISTS promotions (
  promotion_id int(11) NOT NULL AUTO_INCREMENT,
  restaurant_id int(11) NOT NULL,
  name varchar(225) NOT NULL,
  pstatus int(1) NOT NULL DEFAULT '1',
  price decimal(4,2) DEFAULT NULL,
  end_date datetime DEFAULT NULL,
  PRIMARY KEY (promotion_id),
  KEY restaurant_id (restaurant_id)
)  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table promotions
--


-- --------------------------------------------------------

--
-- Table structure for table promotion_items
--

CREATE TABLE IF NOT EXISTS promotion_items (
  promotion_id int(11) NOT NULL,
  item_id int(11) NOT NULL,
  PRIMARY KEY (promotion_id,item_id),
  KEY item_id (item_id)
)  DEFAULT CHARSET=utf8;

--
-- Dumping data for table promotion_items
--


-- --------------------------------------------------------

--
-- Table structure for table regions
--

CREATE TABLE IF NOT EXISTS regions (
  region_id int(11) NOT NULL AUTO_INCREMENT,
  district varchar(225) NOT NULL DEFAULT '',
  city varchar(225) NOT NULL DEFAULT '',
  PRIMARY KEY (region_id,district,city)
)   DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table regions
--

INSERT INTO regions (region_id, district, city) VALUES
(1, 'Sariyer', 'Istanbul'),
(2, 'Besiktas', 'Istanbul'),
(3, 'Kartal', 'Istanbul'),
(4, 'Mecidiyekoy', 'Istanbul'),
(5, 'Ulus', 'Ankara'),
(6, 'Cankaya', 'Ankara'),
(7, 'Kecioren', 'Ankara');

-- --------------------------------------------------------

--
-- Table structure for table restaurants
--

CREATE TABLE IF NOT EXISTS restaurants (
  owner_id int(11) NOT NULL,
  restaurant_id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(225) DEFAULT NULL,
  start_hr decimal(2,0) DEFAULT NULL,
  start_min decimal(2,0) DEFAULT NULL,
  end_hr decimal(2,0) DEFAULT NULL,
  end_min decimal(2,0) DEFAULT NULL,
  item_count int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (restaurant_id),
  KEY owner_id (owner_id)
)   DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table restaurants
--

INSERT INTO restaurants (owner_id, restaurant_id, name, start_hr, start_min, end_hr, end_min, item_count) VALUES
(2, 1, 'Oz Zonguldak Restaurant', 6, 30, 13, 13, 3),
(2, 3, 'BCS', 4, 0, 12, 0, 0),
(2, 7, 'Catispor Kabap Kulubu', 4, 0, 23, 0, 1),
(2, 4, 'Cati', 0, 0, 12, 12, 0),
(2, 5, 'Mis Kabap', 0, 0, 13, 13, 1),
(2, 6, 'Mislo', 10, 0, 23, 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table restaurant_addresses
--

CREATE TABLE IF NOT EXISTS restaurant_addresses (
  restaurant_id int(11) NOT NULL,
  door_number int(11) NOT NULL,
  street varchar(225) DEFAULT NULL,
  district varchar(225) DEFAULT NULL,
  city varchar(225) DEFAULT NULL,
  PRIMARY KEY (restaurant_id)
)  DEFAULT CHARSET=utf8;

--
-- Dumping data for table restaurant_addresses
--

INSERT INTO restaurant_addresses (restaurant_id, door_number, street, district, city) VALUES
(1, 0, 'asd', 'asd', 'asd'),
(7, 0, '0', 'Sariyer', 'Istanbul'),
(3, 55, '123', '123', '123'),
(4, 22, '12', 'Sariyer', 'Istanbul'),
(5, 13, 'sdf', 'Sariyer', 'Istanbul'),
(6, 30, '30', '040', '400');

-- --------------------------------------------------------

--
-- Table structure for table restaurant_feedbacks
--

CREATE TABLE IF NOT EXISTS restaurant_feedbacks (
  user_id int(11) NOT NULL,
  order_id int(11) NOT NULL,
  service_rank int(2) NOT NULL,
  taste_rank int(2) NOT NULL,
  speed_rank int(2) NOT NULL,
  comment text,
  PRIMARY KEY (user_id,order_id),
  KEY order_id (order_id)
)  DEFAULT CHARSET=utf8;

--
-- Dumping data for table restaurant_feedbacks
--

INSERT INTO restaurant_feedbacks (user_id, order_id, service_rank, taste_rank, speed_rank, comment) VALUES
(1, 6, 4, 4, 8, 'Nice'),
(1, 5, 3, 9, 5, '');

-- --------------------------------------------------------

--
-- Table structure for table restaurant_regions
--

CREATE TABLE IF NOT EXISTS restaurant_regions (
  restaurant_id int(11) NOT NULL,
  region_id int(11) NOT NULL,
  avg_delivery decimal(3,0) NOT NULL DEFAULT '120',
  PRIMARY KEY (restaurant_id,region_id),
  KEY region_id (region_id)
)  DEFAULT CHARSET=utf8;

--
-- Dumping data for table restaurant_regions
--

INSERT INTO restaurant_regions (restaurant_id, region_id, avg_delivery) VALUES
(1, 5, 100),
(3, 1, 110),
(1, 1, 45),
(7, 1, 65),
(6, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE IF NOT EXISTS users (
  user_id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(26) NOT NULL,
  password varchar(225) NOT NULL,
  email varchar(225) NOT NULL,
  name varchar(225) CHARACTER SET utf8 NOT NULL,
  phone varchar(10) NOT NULL,
  type int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (user_id,username),
  UNIQUE KEY username (username)
)   DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table users
--

INSERT INTO users (user_id, username, password, email, name, phone, type) VALUES
(1, 'bcs', 'd4ca6a62c30942eff19e41795db945ac', 'me@bcs.com', 'Buğra Can Sefercik', 1231231230, 1),
(2, 'rest', 'd4ca6a62c30942eff19e41795db945ac', 'rrr@rr.com', 'restaurant owner', 2147483647, 3),
(3, 'sadfasdf', 'd4ca6a62c30942eff19e41795db945ac', 'bsfer@asd.com', 'sadf asdf', 2147483647, 1);

-- --------------------------------------------------------

--
-- Table structure for table users_customer
--

CREATE TABLE IF NOT EXISTS users_customer (
  user_id int(11) NOT NULL,
  bonus int(11) NOT NULL,
  PRIMARY KEY (user_id)
)  DEFAULT CHARSET=utf8;

--
-- Dumping data for table users_customer
--

INSERT INTO users_customer (user_id, bonus) VALUES
(1, 0),
(2, 0),
(3, 0);

-- --------------------------------------------------------

--
-- Table structure for table users_owner
--

CREATE TABLE IF NOT EXISTS users_owner (
  user_id int(11) NOT NULL,
  PRIMARY KEY (user_id)
)  DEFAULT CHARSET=utf8;

--
-- Dumping data for table users_owner
--

SET foreign_key_checks = 1;