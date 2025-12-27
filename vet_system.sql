

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vet_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `register_role` enum('farmer','vet') NOT NULL,
  `speciality` enum('Large Animals','All Animals','Small Animals','Poultry','Dairy') DEFAULT 'All Animals',
  `status` enum('Available','Busy') DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact`, `password`, `location`, `register_role`, `speciality`, `status`, `created_at`) VALUES
(1, 'gogo', 'gogo@gmail.com', '0000', '$2y$10$47Lwj/.CIy9DRS0jCnvZveo3hgDqj/3R35EwJfXZOQZdvgZXCXbvu', 'Lubao', 'vet', NULL, 'Available', '2025-04-07 18:44:16'),
(2, '', '', '', '$2y$10$i4dXvpGEPvfB2FIJDNmgf./cy1wzSuPwyxxNvUebJrH5SQR9Bz5Sm', '', 'farmer', NULL, 'Available', '2025-04-07 18:45:36'),
(3, 'chifu', 'chifu@gmail.com', '2222', '$2y$10$vL8gxogdpXyx8LmfEPCDdeLuDx9twfy2Bp8n8eZm/dyo5QI/v/xCO', 'Tongaren', 'vet', 'All Animals', 'Available', '2025-04-07 18:55:45'),
(4, 'kiki', 'kiki@gmail.com', '6666', '$2y$10$IB1HT/Yh9qJ6.lRnJdqyYO6rfSWTXSlwRp59vQaWWU2H4xkB7xa9W', 'kilifi', 'farmer', 'All Animals', 'Available', '2025-04-07 19:43:35'),
(5, 'gela', 'gela@gmail.com', '', '$2y$10$Zw1vT/qV4lHsaG/Xxv93..Q9BY0teoIanQn9PervnMD6RfiYv0Ji2', 'mwanza', 'vet', 'Small Animals', 'Available', '2025-04-08 04:29:06'),
(6, 'oga', 'oga@gmail.com', '8888', '$2y$10$j.2zAjVp1EmOj51ajnDDfOFUKxf/deTYAWIphatexf056IQJuwR/u', 'Malava', 'farmer', 'All Animals', 'Available', '2025-04-08 06:57:13'),
(7, 'run', 'run@gmail.com', '4444', '$2y$10$F14B6KrZLHw2MQUTv4erfeHE2ftPpGZQB1zPRGjFEAqwqFW68x/U.', 'run', 'farmer', 'All Animals', 'Available', '2025-04-09 03:15:23');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
