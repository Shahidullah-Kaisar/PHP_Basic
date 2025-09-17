-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 09, 2025 at 06:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `content`, `created_at`, `updated_at`) VALUES
(3, 'Learn About PHP', 'learn-about-php', 'PHP is a popular, open-source, server-side scripting language, primarily used for web development to create dynamic and interactive websites and web applications. It can be embedded into HTML and runs on the server to generate content, manage databases, handle forms, and maintain sessions before sending the resulting HTML to the client\'s browser. PHP is known for its large community, ease of use, and compatibility with various operating systems and web servers, powering platforms like WordPress and major sites such as Facebook.  \r\n\r\nKey Aspects of PHP\r\nServer-Side Scripting:\r\nPHP code is executed on the web server, not in the user\'s browser. The server processes the PHP script, and the HTML output is sent to the browser for display. \r\nEmbedding with HTML:\r\nPHP code can be seamlessly integrated with HTML code within the same file, making it flexible to add dynamic features to static pages. \r\nDynamic Content:\r\nDevelopers use PHP to create personalized web content, process form data, manage user sessions, and connect to databases. \r\nOpen-Source and Cross-Platform:\r\nAs an open-source language, PHP is free to use and is available on all major operating systems, including Windows, Linux, and macOS. \r\nDatabase Integration:\r\nIt supports easy integration with various databases, especially relational databases like MySQL, for efficient data management. \r\nEcosystem and Frameworks:\r\nPHP is the backbone of popular content management systems like WordPress, Joomla, and Drupal. Frameworks like Laravel and Symfony are widely used for building large-scale PHP applications. \r\nEase of Learning:\r\nPHP has a relatively short learning curve and a large, supportive community, with abundant online resources and documentation to assist beginners. \r\nHow it Works\r\nA user requests a PHP-enabled page from a web browser. \r\nThe web server receives the request and passes the file to the PHP interpreter. \r\nThe PHP interpreter executes the script, which may involve interacting with a database, processing user input, or performing other tasks. \r\nThe PHP script generates an HTML output. \r\nThe server sends the generated HTML to the user\'s browser, which then renders the web page. ', '2025-09-09 09:49:19', '2025-09-09 09:50:19'),
(4, 'Laravel Yoo', 'laravel-', 'Laravel is a free, open-source PHP web application framework designed for building web applications following the model–view–controller (MVC) architectural pattern. It was created by Taylor Otwell and is known for its elegant syntax and features that streamline common web development tasks.\r\nKey aspects of Laravel:\r\nPHP-based:\r\nIt is built on the PHP programming language, a popular choice for web development.\r\nMVC Architecture:\r\nLaravel follows the Model-View-Controller pattern, which helps organize application logic, separating data (Model), presentation (View), and user interaction handling (Controller).\r\nFeature-rich:\r\nIt includes built-in functionalities for common web development needs such as routing, authentication, database migrations, caching, queues, and more.\r\nEloquent ORM:\r\nLaravel\'s Object-Relational Mapping (ORM) allows developers to interact with databases using expressive PHP syntax instead of raw SQL queries.\r\nBlade Templating Engine:\r\nBlade provides a powerful and lightweight templating engine for creating dynamic web pages.\r\nActive Community & Ecosystem:\r\nLaravel benefits from a large and active community, extensive documentation, and a rich ecosystem of packages and tools.\r\nSecurity Features:\r\nIt includes built-in security measures to protect against common web vulnerabilities like SQL injection and Cross-Site Request Forgery (CSRF).\r\nScalability:\r\nFeatures like Laravel Octane enable high-performance application serving, making it suitable for large and robust applications.', '2025-09-09 10:01:45', '2025-09-09 10:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$10$LMU2p2ozIyGT990cb0Nr4uORBKvFikUNPBvMyErqlD.cDqZnjYkt2', '2025-09-09 09:24:28'),
(2, 'admin2', '$2y$10$NGb2budup0T4po8wkqGoP.L2qXZvdugX/Pvs1rN5VZIPJUX4Bf9FW', '2025-09-09 14:59:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
