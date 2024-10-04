-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Oct 04, 2024 at 06:18 AM
-- Server version: 8.0.39
-- PHP Version: 8.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `message_board`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `content` longtext NOT NULL,
  `sent_from` int NOT NULL,
  `sent_to` int NOT NULL,
  `created_ip` text,
  `modified_ip` text,
  `date_added` datetime DEFAULT NULL,
  `date_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `content`, `sent_from`, `sent_to`, `created_ip`, `modified_ip`, `date_added`, `date_updated`) VALUES
(1, 'asdasdasd', 1, 2, NULL, NULL, '2024-09-26 09:44:55', '2024-09-27 09:44:55'),
(2, 'Pellentesque sagittis euismod rhoncus. Duis at urna eu orci aliquam pellentesque. In ut diam vitae magna fermentum commodo et at neque. Integer in metus quis purus sodales hendrerit sed id mi. Etiam leo nulla, vestibulum ac suscipit nec, tincidunt vel ipsum. Aliquam sit amet lacus lorem. Phasellus non nunc id metus vulputate malesuada. Phasellus venenatis nisi ante, sed porta dolor tincidunt a. Morbi malesuada laoreet quam vel bibendum. Aenean non purus quis mauris lacinia porttitor eget a lorem. Nulla vel elementum neque. Sed dapibus ultrices sapien, sed dictum sem molestie non. Nulla sodales dignissim leo, non finibus elit eleifend in. Vestibulum diam arcu, finibus ut bibendum id, consequat sed lorem. Nunc non condimentum eros, sed consequat elit. Fusce in neque eu urna commodo bibendum.', 1, 4, NULL, NULL, '2024-09-27 09:44:55', '2024-09-27 09:44:55'),
(3, 'yowwwww', 2, 1, NULL, NULL, '2024-09-30 09:12:10', NULL),
(4, 'wasupppp', 2, 1, NULL, NULL, '2024-09-30 09:12:19', NULL),
(5, 'wwweeeew', 1, 2, NULL, NULL, '2024-10-01 01:03:32', NULL),
(6, 'uspendisse potenti. Integer sit amet maximus sapien. Etiam magna metus, consequat ut laoreet at, posuere at justo. Nulla laoreet interdum lacus, sit amet consectetur est malesuada et. Proin fermentum, sapien ut tincidunt accumsan, neque justo elementum nibh, nec pharetra libero orci interdum nisl. In eu ullamcorper eros, nec posuere quam. Donec et velit et dui consequat ultrices ac vestibulum justo. Morbi lacinia urna eu bibendum pulvinar. Cras bibendum lectus sit amet massa luctus varius. Curabitur a metus vel dui accumsan blandit quis eget justo. Aliquam sit amet mi blandit, hendrerit odio sit amet, ultricies odio. Morbi vehicula justo at pharetra lobortis. Maecenas eleifend ex a magna maximus, non lobortis sapien fermentum.\n\nAliquam dolor lectus, dictum quis erat hendrerit, convallis sollicitudin nulla. Quisque elit massa, molestie ac lectus a, molestie posuere mi. Duis ultrices euismod felis eu ultrices. Integer iaculis sem velit, non viverra justo dictum ac. Donec sit amet lorem vitae diam tempor bibendum vitae vel nisi. Morbi accumsan ligula non leo dignissim, id iaculis arcu tincidunt. Ut posuere maximus quam. Donec dignissim nisi eu dignissim fringilla. Donec scelerisque turpis augue, vel consequat justo dignissim sed. Nulla sit amet lobortis mi, quis fringilla dui. Phasellus in efficitur dui, non fermentum augue. Vivamus pharetra felis ac cursus pulvinar.', 4, 1, NULL, NULL, '2024-10-01 03:50:34', NULL),
(7, 'Curabitur posuere mi nec ex tempus tempus. Fusce sit amet elit mattis justo facilisis eleifend. Duis libero massa, sagittis id euismod quis, dictum quis turpis. Aliquam dignissim elementum pharetra.', 1, 4, NULL, NULL, '2024-10-01 03:51:12', NULL),
(8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi eget pharetra est, sit amet malesuada libero. Pellentesque eleifend commodo turpis. Nullam nec est nulla. Morbi gravida magna ac nisl mollis consectetur. Aliquam viverra vestibulum sem, a mollis felis lacinia id. Curabitur posuere mi nec ex tempus tempus. Fusce sit amet elit mattis justo facilisis eleifend. Duis libero massa, sagittis id euismod quis, dictum quis turpis. Aliquam dignissim elementum pharetra.', 1, 4, NULL, NULL, '2024-10-01 05:28:48', NULL),
(11, 'magna ac nisl mollis consectetur. Aliquam viverra vestibulum sem, a mollis felis lacinia id. Curabitur posuere mi nec ex tempus tempus. Fusce sit amet elit mattis justo facilisis eleifend. Duis libero massa, sagittis id euismod quis, dictum quis turpis. Aliquam dignissim elementum pharetra.', 4, 1, '192.168.65.1', '192.168.65.1', '2024-10-03 10:20:27', NULL),
(28, 'Eat a live frog first thing in the morning, and nothing worse will happen to you the rest of the day. - Mark Twain', 1, 9, '192.168.65.1', '192.168.65.1', '2024-10-04 09:34:39', NULL),
(29, 'People forget the brain lives inside the body. If the body\'s unhealthy, the brain\'s unhealthy. - Joe De Sena', 1, 10, '192.168.65.1', '192.168.65.1', '2024-10-04 09:34:50', NULL),
(30, 'A mind all logic is like a knife all blade. It makes the hand bleed that uses it.', 1, 11, '192.168.65.1', '192.168.65.1', '2024-10-04 09:35:11', NULL),
(31, 'Don’t worry about people stealing your ideas. If your ideas are any good, you’ll have to ram them down people’s throats.', 1, 12, '192.168.65.1', '192.168.65.1', '2024-10-04 09:35:27', NULL),
(32, 'Fairy tales are more than true: not because they tell us that dragons exist, but because they tell us that dragons can be beaten.', 1, 13, '192.168.65.1', '192.168.65.1', '2024-10-04 09:35:41', NULL),
(33, 'The most difficult thing is the decision to act. The rest is merely tenacity. The fears are paper tigers. You can do anything you decide to do. You can act to change and control your life; and the procedure, the process, is its own reward.', 1, 5, '192.168.65.1', '192.168.65.1', '2024-10-04 09:35:57', NULL),
(35, 'Man, whose teacher is nature, should not be a piece of wax on which an elevated image of some professor is to be carved. ', 1, 4, '192.168.65.1', '192.168.65.1', '2024-10-04 10:49:26', NULL),
(36, 'Don’t be the person who says yes with their mouth but no with their actions. - Ryan Holiday', 4, 1, '192.168.65.1', '192.168.65.1', '2024-10-04 10:51:42', NULL),
(38, 'It was my pride that I was taken in as an equal, in spirit as well as in fact. - Jack London', 1, 4, '192.168.65.1', '192.168.65.1', '2024-10-04 10:54:16', NULL),
(39, 'Live as long as you may, the first twenty years are the longest half of your life. They appear so while they are passing; they seem to have been so when we look back on them; and they take up more room in our memory than all the years that succeed them. -Robert Southey', 4, 1, '192.168.65.1', '192.168.65.1', '2024-10-04 10:55:36', NULL),
(40, 'I will not die an unlived life. I will not live in fear of falling or catching fire. I choose to inhabit my days, to allow my living to open me, to make me less afraid, more accessible; to loosen my heart until it becomes a wing, a torch, a promise. I choose to risk my significance, to live so that which came to me as seed goes to the next as blossom, and that which came to me as blossom, goes on as fruit. - Dawna Markova', 4, 1, '192.168.65.1', '192.168.65.1', '2024-10-04 10:57:06', NULL),
(41, 'Inspiration is for amateurs. The rest of us just show up and get to work. - Chuck Close', 1, 4, '192.168.65.1', '192.168.65.1', '2024-10-04 10:57:37', NULL),
(42, 'The truth is that the dreams that you have are very different from the actions that will get you there. - James Clear', 1, 4, '192.168.65.1', '192.168.65.1', '2024-10-04 11:06:23', NULL),
(43, 'It must be produced and discharged and used up in order to exist at all. - William Faulkner likening gratitude to electricity', 1, 4, '192.168.65.1', '192.168.65.1', '2024-10-04 11:08:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` tinyint DEFAULT NULL,
  `hobby` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `last_login_time` datetime DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `image`, `password`, `birthdate`, `gender`, `hobby`, `last_login_time`, `date_added`, `date_updated`) VALUES
(1, 'vannnn', 'fdc.vanomar@gmail.com', '66ff82174ae4c.png', '309c9f34adaa1ea63ee828c0ba75c0428b55c427', '2024-10-16', 1, 'me is wasup', '2024-10-04 14:16:20', '2024-09-30 15:42:38', NULL),
(2, 'ncwww', 'fdc1.vanomar@gmail.com', NULL, '309c9f34adaa1ea63ee828c0ba75c0428b55c427', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'ncwww3', 'fdc2.vanomar@gmail.com', '66ff83b9b2416.jpeg', '309c9f34adaa1ea63ee828c0ba75c0428b55c427', '2024-10-10', 2, 'YOww', '2024-10-04 14:15:58', '2024-10-01 11:18:21', NULL),
(5, 'wewewew', 'fdc3.vanomar@gmail.com', NULL, '309c9f34adaa1ea63ee828c0ba75c0428b55c427', NULL, NULL, NULL, '2024-10-02 08:22:38', '2024-10-02 08:22:38', NULL),
(9, 'Asdsdsa', 'fdc4.vanomar@gmail.com', NULL, '309c9f34adaa1ea63ee828c0ba75c0428b55c427', NULL, NULL, NULL, '2024-10-02 08:38:32', '2024-10-02 08:38:32', NULL),
(10, 'fdccc5', 'fdc5.vanomar@gmail.com', NULL, '309c9f34adaa1ea63ee828c0ba75c0428b55c427', NULL, NULL, NULL, '2024-10-03 16:07:38', '2024-10-03 16:07:38', NULL),
(11, 'fdccc6', 'fdc6.vanomar@gmail.com', NULL, '309c9f34adaa1ea63ee828c0ba75c0428b55c427', NULL, NULL, NULL, '2024-10-03 16:16:25', '2024-10-03 16:16:25', NULL),
(12, 'fdccc7', 'fdc7.vanomar@gmail.com', NULL, '309c9f34adaa1ea63ee828c0ba75c0428b55c427', NULL, NULL, NULL, '2024-10-03 16:16:59', '2024-10-03 16:16:59', NULL),
(13, 'fdccc8', 'fdc8.vanomar@gmail.com', NULL, '309c9f34adaa1ea63ee828c0ba75c0428b55c427', NULL, NULL, NULL, '2024-10-03 16:17:13', '2024-10-03 16:17:13', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
