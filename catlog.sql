-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2024 at 03:44 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catalog`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `image`, `name`) VALUES
(14, 'CatagoeryUplods/360_F_176975606_NENcObythCwyPxA6n5vSKxwc8lVLa3In.jpg', 'Electronics'),
(16, 'CatagoeryUplods/books-1204029_640.jpg', 'Books'),
(17, 'CatagoeryUplods/footwear._SS300_QL85_FMpng_.png', 'Footwear'),
(19, 'CatagoeryUplods/71NIJk6HjrL._AC_SR480,570_.jpg', 'Computers'),
(20, 'CatagoeryUplods/61eC6QIQ+6L._AC_UL320_.jpg', 'Toys'),
(22, 'CatagoeryUplods/61ESEPGpJPL._SX679_.jpg', 'watches');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_name`, `total_price`, `order_date`, `status`) VALUES
(9, 'abc', '1998.00', '2024-09-09 13:20:54', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `price`) VALUES
(14, 9, 'AirpodMax', '999.00'),
(15, 9, 'MacBook m2', '999.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `productimage` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productimage`, `name`, `price`, `category_id`) VALUES
(9, 'uploads/airpods-max-in-black.jpg', 'AirpodMax', '999.00', 14),
(10, 'uploads/iphone15pro.jpeg', 'iphone15', '999.00', 14),
(11, 'uploads/mackbook.jpeg', 'MacBook m2', '999.00', 14),
(12, 'uploads/NeoQled.jpg', 'NeoQled 8k', '999.00', 14),
(13, 'uploads/samsungm21.jpg', 'samsungs21', '999.00', 14),
(15, 'uploads/watch.png', 'Apple Watch', '999.00', 14),
(16, 'uploads/close-up-of-the-bhagavad-gita-BNFTCX.jpg', 'Bhagavad gita', '10.00', 16),
(17, 'uploads/31293f45-7c8f-4605-ac1f-6a281802a6e5.__CR0,0,300,300_PT0_SX300_V1___.jpg', 'Ramayan', '10.00', 16),
(18, 'uploads/610efca2VyL._AC_UF1000,1000_QL80_.jpg', 'Mahabarat', '20.00', 16),
(19, 'uploads/71D0EwijhNL._AC_UF1000,1000_QL80_.jpg', 'Chanakya neeti', '20.00', 16),
(20, 'uploads/71Y9OTWj8ZL._AC_UF1000,1000_QL80_.jpg', 'TheRichestManIn...', '20.00', 16),
(21, 'uploads/81lOhiZO2CL._AC_UF1000,1000_QL80_.jpg', 'The Secret', '20.00', 16),
(22, 'uploads/71KKZlVjbwL._AC_UF1000,1000_QL80_.jpg', 'the Wings of Fire', '20.00', 16),
(23, 'uploads/61xhX3nzEBL._AC_UF1000,1000_QL80_.jpg', 'Swami Vivekanand', '20.00', 16),
(24, 'uploads/GIANNIS+FREAK+6+TB+EP.png', 'Giannis nike', '100.00', 17),
(25, 'uploads/NIKE+CORTEZ.png', 'Cortez', '100.00', 17),
(26, 'uploads/NIKE+ZOOM+VOMERO+5.png', 'Vomero', '100.00', 17),
(27, 'uploads/51-CObvtVsL._AC_UL320_.jpg', 'sneaker', '100.00', 17),
(28, 'uploads/61fcVae7y9S._AC_UL320_.jpg', 'white n Black', '50.00', 17),
(29, 'uploads/71Als4wFYJL._AC_UL320_.jpg', 'sport', '50.00', 17),
(30, 'uploads/41035zzA7gL._AC_UL320_.jpg', 'carina', '100.00', 17),
(37, 'uploads/51cBP0cdI-L._AC._SR360,460.jpg', 'Sandisk flashdrive(c)', '10.00', 19),
(38, 'uploads/51qu8mNXlTL._AC._SR360,460.jpg', 'TypeC cable', '10.00', 19),
(39, 'uploads/51yjnWJ5urL._AC._SR360,460.jpg', 'logitech Keybord', '999.00', 19),
(40, 'uploads/61qm452yy-L._AC._SR360,460.jpg', 'logitech mouse', '999.00', 19),
(41, 'uploads/617EOdxqj9L._AC._SR360,460.jpg', 'hp Flashdrive', '20.00', 19),
(42, 'uploads/61OmKcFeFkL._AC._SR360,460.jpg', 'hdmi Cable', '10.00', 19),
(43, 'uploads/61tPYsj5cGL._AC_SR480,570_.jpg', '1 in 8 hub', '100.00', 19),
(44, 'uploads/41-3p79ueuL.AC_SX250.jpg', 'truck', '50.00', 20),
(45, 'uploads/41aHnwL-hRL.AC_SX250.jpg', 'solimo', '100.00', 20),
(46, 'uploads/51pNXXFChqL.AC_SX250.jpg', 'cards', '50.00', 20),
(47, 'uploads/515N2Got1BL.AC_SX250.jpg', 'quize', '50.00', 20),
(48, 'uploads/41SMFsDvi2L.AC_SX250.jpg', 'softToy', '50.00', 20),
(49, 'uploads/41bTLf3qy0L.AC_SX250.jpg', 'carryCart', '50.00', 20),
(50, 'uploads/413Ystx8aoL.AC_SX250.jpg', 'nerf Gun', '50.00', 20),
(52, 'uploads/ca1ade8c-5ebb-49d3-8b6d-de87d1353e4f22220640_416x416.jpg', 'Boat Headphones', '50.00', 14),
(53, 'uploads/31PkSJbWV3L.AC_SX250.jpg', 'Fastrack', '50.00', 22),
(54, 'uploads/41NdBBeBgkL.AC_SX250.jpg', 'Fastrack silver', '50.00', 22),
(55, 'uploads/41PZquLBbDL.AC_SX250.jpg', 'Titan', '50.00', 22),
(56, 'uploads/41uhGFB2nPL.AC_SX250.jpg', 'Quartz', '50.00', 22),
(57, 'uploads/81K562wi+bL._SX522_.jpg', 'Louis Devin', '50.00', 22),
(58, 'uploads/51cJGQYfTSL.AC_SX250.jpg', 'Brsclet', '50.00', 22);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `userType`) VALUES
(1, 'vasu', 'vasu', 'admin'),
(2, 'abc', 'abc', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
