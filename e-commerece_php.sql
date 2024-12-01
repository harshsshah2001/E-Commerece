-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 02:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-commerece php`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_arrivals`
--

CREATE TABLE `add_arrivals` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_arrivals`
--

INSERT INTO `add_arrivals` (`id`, `title`, `price`, `image`) VALUES
(5, 'Peny shirts', 242, 'cat-sm-item2.jpg'),
(6, 'Crove Tops', 125, 'insta-item5.jpg'),
(7, 'Neef Below', 214, 'product-item-10.jpg'),
(8, 'lems Lengis', 199, 'cat-large-item2.jpg'),
(9, 'new niks', 214, 'insta-item1.jpg'),
(10, 'pairs Pent', 421, 'insta-item6.jpg'),
(11, 'selan shirt', 356, 'post-large-image1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `add_collection`
--

CREATE TABLE `add_collection` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `paragraph` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_collection`
--

INSERT INTO `add_collection` (`id`, `title`, `paragraph`, `image`) VALUES
(3, 'Jcky Jeans', 'Jeans is a good Products and also good degin in own and also make a good things and better valuable jeans', 'insta-item3.jpg'),
(4, 'shirt', 'Pick best quality Shirts for men, women & kids online in India. Get formal, casual, sleep & dog Shirt starting from Rs149', 'insta-item2.jpg'),
(5, 'shy shirt', 'This SHirt is made for specifically womaans and mens. And it is a best for mens and persons', 'banner-image-4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `admin_register`
--

CREATE TABLE `admin_register` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_register`
--

INSERT INTO `admin_register` (`id`, `name`, `email`, `password`, `remember_token`) VALUES
(8, 'admin', 'admin@gmail.com', '$2y$10$sfD23sC1gOQaC.M29h1zOOlnLIzuFrcdXFe3bWYhto0VDRjG09xOe', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `best_selling_items`
--

CREATE TABLE `best_selling_items` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` int(255) NOT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `best_selling_items`
--

INSERT INTO `best_selling_items` (`id`, `name`, `image`, `price`, `user_id`) VALUES
(8, 'TOP\'s', 'cat-item2.jpg', 635, '0'),
(10, 'T-shirt', 'cat-item1.jpg', 899, '0'),
(11, 'lengi\'s', 'product-item-2.jpg', 999, '0'),
(12, 'Skirt\'s', 'insta-item5.jpg', 555, '0'),
(13, 'Pent\'s', 'product-item-6.jpg', 666, '0'),
(14, 'lengi&#039;s', 'product-item-2.jpg', 999, 'harshsshah2001@gmail.com'),
(15, 'T-shirt', 'cat-item1.jpg', 899, 'harshsshah2001@gmail.com'),
(16, 'Skirt&#039;s', 'insta-item5.jpg', 555, 'harshsshah2001@gmail.com'),
(17, 'Pent&#039;s', 'product-item-6.jpg', 666, 'harshsshah2001@gmail.com'),
(18, 'TOP&#039;s', 'cat-item2.jpg', 635, 'harshsshah2001@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(255) NOT NULL,
  `otp` int(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_reset`
--

INSERT INTO `password_reset` (`id`, `otp`, `email`) VALUES
(28, 29173, 'harshsshah2001@gmail.com'),
(29, 45786, 'harshsshah2001@gmail.com'),
(30, 91267, 'harshsshah2001@gmail.com'),
(31, 9123, 'harshsshah2001@gmail.com'),
(32, 62408, 'harshsshah2001@gmail.com'),
(33, 36582, 'harshsshah2001@gmail.com'),
(34, 14029, 'harshsshah2001@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `name`, `order_id`, `amount`, `email`) VALUES
(2, 'harsh', 'pay_PPsMKVyQ9DF9XZ', 242, 'harshsshah2001@gmail.com'),
(3, 'harsh', 'pay_PPsvTAA1QIXE37', 242, 'harshsshah2001@gmail.com'),
(4, 'harsh', 'pay_PPtX4RtY8Cvxo6', 242, 'harshsshah2001@gmail.com'),
(5, 'harsh', 'pay_PPtf7PX6MRLMbc', 242, 'harshsshah2001@gmail.com'),
(6, 'harsh', 'pay_PPtgQI6lTppohV', 242, 'harshsshah2001@gmail.com'),
(7, 'harsh', 'pay_PQdgXYQlHid2Da', 242, 'harshsshah2001@gmail.com'),
(8, 'harsh', 'pay_PQdhGCj5bp9Lfz', 214, 'harshsshah2001@gmail.com'),
(9, 'harsh', 'pay_PQeXr91qeonCaX', 199, 'harshsshah2001@gmail.com'),
(10, 'harsh', 'pay_PQejPo8qhMqW2B', 242, 'harshsshah2001@gmail.com'),
(11, 'harsh', 'pay_PQeuYoeh2WxpJ4', 242, 'harshsshah2001@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_register`
--

CREATE TABLE `user_register` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `otp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_register`
--

INSERT INTO `user_register` (`id`, `name`, `phone`, `image`, `email`, `password`, `created_at`, `otp`) VALUES
(53, 'jaishika', '2152362541', 'banner-image-3.jpg', 'jaishika2709tata@gmail.com', '$2y$10$Z4qmPpXEJ88gUE/jZ9Ru3O1X0T7tZh67m0XUO0lDU47IcDTRBjWUe', '2024-11-23 05:49:46', '52317'),
(57, 'index', '2536214562', 'banner-image-5.jpg', 'neel@gmail.com', '$2y$10$VQuvEk9stiaFYs4QR6ffsObgKEUWNXUicU/Xts3OzFPEvmchYoA5S', '2024-11-23 06:16:30', '67539'),
(68, 'harsh', '2365231256', 'insta-item5.jpg', 'harshsshah2001@gmail.com', '$2y$10$Lm6rBZ3u6itSZvSJI6byDucBDWVsS1P1S31UN8PTLJxlfTyxCZa3C', '2024-11-27 16:47:15', '02753');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `title`, `price`, `image`, `user_id`) VALUES
(5, 'Peny shirts', 242, 'cat-sm-item2.jpg', 'harsh@gmail.com'),
(8, 'Crove Tops', 125, 'insta-item5.jpg', 'harsh@gmail.com'),
(10, 'Neef Below', 214, 'product-item-10.jpg', 'harsh@gmail.com'),
(11, 'Crove Tops', 125, 'insta-item5.jpg', 'mahesh@gmail.com'),
(12, 'new niks', 214, 'insta-item1.jpg', 'mahesh@gmail.com'),
(24, 'Crove Tops', 125, 'insta-item5.jpg', 'abcd@gmail.com'),
(33, 'T-shirt', 899, 'cat-item1.jpg', 'harshsshah2001@gmail.com'),
(34, 'lengi&#039;s', 999, 'product-item-2.jpg', 'harshsshah2001@gmail.com'),
(35, 'Crove Tops', 125, 'insta-item5.jpg', 'harshsshah2001@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_arrivals`
--
ALTER TABLE `add_arrivals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `add_collection`
--
ALTER TABLE `add_collection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_register`
--
ALTER TABLE `admin_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `best_selling_items`
--
ALTER TABLE `best_selling_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_register`
--
ALTER TABLE `user_register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_arrivals`
--
ALTER TABLE `add_arrivals`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `add_collection`
--
ALTER TABLE `add_collection`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin_register`
--
ALTER TABLE `admin_register`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `best_selling_items`
--
ALTER TABLE `best_selling_items`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_register`
--
ALTER TABLE `user_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
