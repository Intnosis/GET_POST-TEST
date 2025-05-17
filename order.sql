-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 10:03 AM
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
-- Database: `order`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending',
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(2083) DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `quantity`, `image`, `enddate`, `category`) VALUES
(1, 'Pen (Blue)', 1.50, 90, 'pen_blue.png', '2025-05-22', 'Writing tools'),
(2, 'Pen (RED)', 1.50, 85, 'pen_red.png', '2025-05-22', 'Writing tools'),
(3, 'Pen (GREEN)', 1.50, 70, 'pen_green.png', '2025-05-23', 'Writing tools'),
(4, 'Pencil', 1.00, 120, 'pencil1.png', '2025-05-24', 'Writing tools'),
(5, 'Highlighter', 2.00, 60, 'highlighter.png', '2025-05-24', 'Writing tools'),
(6, 'Permanent Marker (Black)', 2.50, 40, 'perm_marker_black.png', '2025-05-25', 'Writing tools'),
(7, 'Permanent Marker (Red)', 2.50, 40, 'perm_marker_red.png', '2025-05-25', 'Writing tools'),
(8, 'Whiteboard Marker', 2.00, 45, 'whiteboard_marker.png', '2025-05-26', 'Writing tools'),
(9, 'Folder (Long)', 1.50, 80, 'folder_long.png', '2025-05-26', 'Writing tools'),
(10, 'Folder (Short)', 1.20, 90, 'folder_short.png', '2025-05-26', 'Writing tools'),
(11, 'Bond Paper (Long)', 3.50, 70, 'bond_long.png', '2025-05-27', 'Writing tools'),
(12, 'Bond Paper (Short)', 3.00, 80, 'bond_short.png', '2025-05-27', 'Writing tools'),
(13, 'Brown Envelope (Long)', 1.00, 100, 'brown_long.png', '2025-05-28', 'Writing tools'),
(14, 'Brown Envelope (Short)', 0.80, 120, 'brown_short.png', '2025-05-28', 'Writing tools'),
(15, 'Yellow Paper', 2.00, 60, 'yellow_paper.png', '2025-05-29', 'Writing tools'),
(16, 'Index Cards', 1.50, 100, 'index_cards.png', '2025-05-29', 'Writing tools'),
(17, 'Manila Paper', 1.00, 150, 'manila_paper.png', '2025-05-30', 'Writing tools'),
(18, 'Construction Paper', 2.50, 90, 'construction_paper.png', '2025-05-30', 'Writing tools'),
(19, 'Blue Notebook', 2.20, 40, 'blue_notebook.png', '2025-05-01', 'Writing tools'),
(20, 'Eraser', 0.50, 200, 'eraser.png', '2025-05-01', 'Writing tools'),
(21, 'Ruler', 1.20, 150, 'ruler.png', '2025-05-02', 'Writing tools'),
(22, 'Sharpener', 0.80, 130, 'sharpener.png', '2025-05-02', 'Writing tools'),
(23, 'Correction Tape', 2.50, 70, 'correction_tape.png', '2025-05-02', 'Writing tools'),
(24, 'PE Bag', 5.00, 60, 'pe_bag.png', '2025-05-03', 'Writing tools'),
(25, 'Planner', 6.00, 40, 'planner.png', '2025-06-03', 'Writing tools'),
(26, 'Neck Tie', 3.50, 70, 'neck_tie.png', '0025-06-04', 'Writing tools'),
(27, 'School Shirt', 7.00, 50, 'school_shirt.png', '0025-06-04', 'Writing tools'),
(28, 'School Uniform', 10.00, 40, 'school_uniform.png', '2025-06-05', 'Writing tools'),
(29, 'PE Uniform', 8.00, 45, 'pe_uniform.png', '2025-06-05', 'Writing tools');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('buyer','seller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
