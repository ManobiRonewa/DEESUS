-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 18, 2024 at 10:34 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deesus`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_url` varchar(255) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `post_date` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `image_url`, `title`, `description`, `post_date`) VALUES
(1, 'images/blog/b1.jpg', 'Kids Clothes', 'Children\'s clothing or kids\' clothing is clothing for children who have not yet grown to full height. Children\'s clothing is often more casual than adult clothing, fit for play and rest. Children\'s clothing needs to be useful for playing...', '2024-04-28'),
(2, 'images/blog/b2.jpg', 'Adult Clothes', 'When choosing attire that demonstrates maturity for an adult, there are several factors to consider. Here are some tips on how to dress in a way that conveys maturity...', '2024-01-13'),
(3, 'images/blog/b3.webp', 'Summer Clothes', 'Clothing for spring/summer is often airy and made of breathable, moisture-wicking and/or lightweight fabrics. Casual cotton fabrics and typical linen summer materials are widely used...', '0000-00-00'),
(4, 'images/blog/b4.jpg', 'Winter Clothes best', 'Winter clothes are especially outerwear like coats, jackets, hats, scarves and gloves or mittens, earmuffs, but also warm underwear like long underwear...', '2024-06-13'),
(5, 'images/blog/b6.jpg', 'Formal', 'Formal clothing is often worn to follow norms, but also serves to obtain respect, signaling professionalism and maintenance of social distance...', '2024-01-04'),
(9, 'images/t4.jpg', '  Everything About Tees', 'From casual tees, we cover everything you need to know to stay stylish. Join us on a journey to find the perfect shirt for every occasion', '2024-10-27');

-- --------------------------------------------------------

--
-- Table structure for table `checkoutinfo`
--

DROP TABLE IF EXISTS `checkoutinfo`;
CREATE TABLE IF NOT EXISTS `checkoutinfo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `id_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `expiry_date` varchar(7) NOT NULL,
  `terms_accepted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `checkoutinfo`
--

INSERT INTO `checkoutinfo` (`id`, `first_name`, `last_name`, `id_number`, `address`, `city`, `card_number`, `expiry_date`, `terms_accepted`, `created_at`, `user_id`, `email`) VALUES
(6, 'confidence', 'nonyana', '0605147545', 'dobsonville, 102 cornation street', 'johannesburg', '45647357334', '29', 0, '2024-10-28 19:22:04', '13', 'confidence@gmail.com'),
(5, 'Ronewa', 'Manobi', '00032343084', 'florida, 23 kerk', 'johannesburg', '549797373378', '27', 1, '2024-10-09 18:32:10', '12', 'ronny@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_size` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `email`, `product_name`, `product_image`, `product_size`, `price`, `quantity`, `total`, `order_date`) VALUES
(25, 'mvelomtungwa@gmail.com', 'Denim Box Frock', 'images/products/kids/d2.webp', 'XX', 150.00, 3, 450.00, '2024-10-30 07:43:15'),
(26, 'lema@gmail.com', 'OBEY BIG WIG CARGO DENIM JEANS (LIGHT INDIGO)', 'images/prod2.png', 'M', 698.64, 2, 1397.28, '2024-10-30 07:51:21'),
(24, 'confidence@gmail.com', 'PAPERBAG - Relaxed fit jeans', 'images/products/jeans/6.jpg', 'X', 700.00, 1, 700.00, '2024-10-15 14:23:06'),
(22, 'ben@gmail.com', '2pcs Children Short Sleeves T-shirt Suit Cartoon Printing Breathable Tops Shorts Set For Boys Aged 0-6', 'images/products/kids/2p.jpg', 'M', 300.00, 1, 300.00, '2024-10-23 15:33:59'),
(23, 'confidence@gmail.com', 'Men\'s T Shirts Sexy Tattoo T-shirt Casual O Collar Super Street Loose Beach Hip Hop Trend Alternative Personality Short Sleeve', 'images/products/t-shirt/t9.jpg', 'X', 300.00, 1, 300.00, '2024-10-15 14:23:06'),
(19, 'ben@gmail.com', 'Head Victoria T-Shirt V-Neck - white/pink', 'images/products/t-shirt/t3.jpg', 'M', 456.88, 1, 456.00, '2024-10-23 15:27:54'),
(20, 'ben@gmail.com', 'Head Victoria T-Shirt V-Neck - white/pink', 'images/products/t-shirt/t3.jpg', 'M', 456.88, 1, 456.00, '2024-10-24 15:30:14'),
(21, 'ben@gmail.com', 'Jacob Cohën straight-leg denim jeans', 'images/products/jeans/5.jfif', 'X', 567.98, 1, 567.00, '2024-10-28 15:30:14'),
(29, 'sir@gmail', 'OBEY BIG WIG CARGO DENIM JEANS (LIGHT INDIGO)', 'images/prod2.png', 'S', 698.64, 2, 1397.28, '2024-10-30 08:44:09'),
(28, 'jack@gmail.com', 'Short Sleeve Oversized Linen Revere Shirt', 'images/products/shirt/s3.webp', 'M', 250.50, 1, 250.00, '2024-10-30 08:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `rating` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand`, `product_name`, `price`, `image_url`, `rating`) VALUES
(1, 'Obey', 'OBEY BIG WIG CARGO DENIM JEANS (LIGHT INDIGO)', 698.64, 'images/products/jeans/baggy4.webp', 5),
(2, 'Blank Nyc Jeans', ' NYC The Baxter Womens Ribcage Straight Leg Jeans', 654.78, 'images/products/jeans/2.jfif', 5),
(3, 'Wrangler Texas', 'Wrangler Texas Jeans New Favorite K', 550.00, 'images/products/jeans/3.webp', 5),
(4, 'XOXO Jeans', 'XOXO Jeans Size 1/2 lot of 3 Vintage Y2K 2000s', 444.54, 'images/products/jeans/4.jpg', 5),
(5, 'Jacob Cohën', 'Jacob Cohën straight-leg denim jeans', 567.98, 'images/products/jeans/5.jfif', 5),
(6, 'DeFacto', 'PAPERBAG - Relaxed fit jeans', 700.00, 'images/products/jeans/6.jpg', 5),
(7, 'Biggest Denim', 'This Year’s Biggest Denim Trends For Men', 789.88, 'images/products/jeans/8.jpg', 5),
(8, 'Minimum', 'SIMS - Basic T-shirt', 80.00, 'images/products/t-shirt/t2.jpg', 5),
(9, 'Ebay', 'CCM Senior Training Tee T-Shirt', 350.00, 'images/products/t-shirt/t1.jfif', 5),
(10, 'Head Victoria', 'Head Victoria T-Shirt V-Neck - white/pink', 456.88, 'images/products/t-shirt/t3.jpg', 5),
(11, 'CCM', 'CCM T-Shirt Women\'s Crew Neck Sr BLACK', 350.00, 'images/products/t-shirt/t4.jpg', 5),
(12, 'The Pingpong', 'The Pingpong Shirts Sports T-shirts Men Women Quick Dry Breathable Table Tennis Shirts Running Shirt Fitness Tennis Shirts Jd4', 345.00, 'images/products/t-shirt/t5.jpg', 5),
(13, 'Lisbeth Six', 'Lisbeth Six Print Crew Neck Tee', 120.00, 'images/products/t-shirt/t6.webp', 5),
(14, 'Woman Badminton', 'Woman Badminton Jersey 2020 Li-ning Badminton Profession T-shirt, Li ning AAYQ088', 400.00, 'images/products/t-shirt/t7.webp', 5),
(15, 'The Scarab', 'The Scarab T-Shirt', 250.00, 'images/products/t-shirt/t8.webp', 5),
(16, 'Men\'s T Shirts', 'Men\'s T Shirts Sexy Tattoo T-shirt Casual O Collar Super Street Loose Beach Hip Hop Trend Alternative Personality Short Sleeve', 300.00, 'images/products/t-shirt/t9.jpg', 5),
(17, 'Oxford shirt', 'Oxford shirt Regular Fit', 700.00, 'images/products/shirt/s1.jpg', 5),
(18, 'Gant', 'The Sustainable Edit Casual Poplin Shirt', 300.00, 'images/products/shirt/s2.jfif', 5),
(19, 'Short Sleeve', 'Short Sleeve Oversized Linen Revere Shirt', 250.50, 'images/products/shirt/s3.webp', 5),
(20, 'Oxford shirt', 'Relaxed Fit Oxford shirt', 500.00, 'images/products/shirt/s4.jfif', 5),
(21, 'KCYSTA', 'Men\'s Shirt Vintage Retro 80s 90s Geometric Fantastic Casual Attractive Design Bowling Shirts for Men Women for Gift to Husband', 450.00, 'images/products/shirt/s5.webp', 5),
(22, 'Super Kitty Kat', 'Samurai Cat Hawaiian Shirt', 500.00, 'images/products/shirt/s6.webp', 5),
(23, 'Zonanza', 'Men Slim Fit Printed Mandarin Collar Casual Shirt', 350.00, 'images/products/shirt/s7.jpeg', 5),
(24, '2pcs', '2pcs Children Short Sleeves T-shirt Suit Cartoon Printing Breathable Tops Shorts Set For Boys Aged 0-6', 300.00, 'images/products/kids/2p.jpg', 5),
(25, 'Baby girl frock', 'Red pink grey checked skirts beautiful girl removing elegant frock dress for baby', 300.00, 'images/products/kids/2pc.jpeg', 5),
(26, 'DHgate', 'Baby girls dress Child lapel college wind bowknot short sleeve pleated polo shirt skirt children casual designer clothing kids clothes, Size 90-150cm', 250.00, 'images/products/kids/d1.webp', 5),
(27, 'Baby girl frock', 'Denim Box Frock', 150.00, 'images/products/kids/d2.webp', 5),
(28, 'Disney', 'Disney Mickey and Friends Toddler/Kids Girl Letter Print Colorblock Lightweight Bomber Jacket', 150.00, 'images/products/kids/j1.webp', 5),
(31, NULL, 'Pink cargo pants', 600.00, 'images/1730103131_1730103130762.jpg', NULL),
(34, NULL, 'black tee', 300.00, 'images/1730278017_1730278017045.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `calls` varchar(200) NOT NULL,
  `password` varchar(500) NOT NULL,
  `role` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `calls`, `password`, `role`) VALUES
(14, 'ben', 'ben@gmail.com', '12345678910', '$2y$10$VI/SCp5FpgYZ0MJ6Col4ROdTbUQ08j7wfChJbJ/hBDZ6rnlrsFJuC', 'user'),
(17, 'lema', 'lema@gmail.com', '12345678911', '$2y$10$6StxyfZh0Nyf2zilkFWGXuf7DPN0itQSFR/eEaVTko42lvZR0QJGu', 'user'),
(12, 'ronny', 'ronny@gmail.com', '0631232382', '$2y$10$8TBx9m0Z7/.k1eCLGm06kufpq0ijTrvrP.Uw.2qWjXj8Ya5gVuPbS', 'admin'),
(13, 'confidence', 'confidence@gmail.com', '0723434023', '$2y$10$KHNuqh4JAmI4UeE9FmhIRe.4JDvZxceyLO6AHdLbbHedRq5EwHvYW', 'user'),
(16, 'mvelo', 'mvelomtungwa@gmail.com', '0626550087', '$2y$10$qjBR/oSTk8u47Cfi/w/whuWsMFsgjVz83oHL.7tN2vnsbzWDQHFNK', 'admin'),
(19, 'sir', 'sir@gmail', '12345678910', '$2y$10$btfF5hF3IRfhl38OHrbHGuk4UdT4yGcj.7S0DdsdIXPlAVZDp2Ofe', 'user'),
(20, 'sir', 'sir@gmail', '12345678910', '$2y$10$YHbzYR8Y6mY..QtQIdUuBeK9OyZZcfudzublun0LXomVG3xsL.xMq', 'user');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
