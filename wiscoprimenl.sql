-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 25, 2022 at 03:31 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wiscoprimenl`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogposts`
--

CREATE TABLE `blogposts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(500) NOT NULL DEFAULT '',
  `slug` varchar(500) DEFAULT NULL,
  `author` varchar(500) NOT NULL DEFAULT '',
  `cover` varchar(500) NOT NULL DEFAULT '',
  `thumb` varchar(500) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `qoute` text DEFAULT NULL,
  `file` varchar(500) DEFAULT NULL,
  `tags` varchar(11) NOT NULL DEFAULT '',
  `views` int(11) NOT NULL DEFAULT 0,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogposts`
--

INSERT INTO `blogposts` (`id`, `title`, `slug`, `author`, `cover`, `thumb`, `body`, `qoute`, `file`, `tags`, `views`, `date_posted`) VALUES
(1, 'Addressing Labor Shortages Through DEI: Overheard in the Big Room  ', '123sdwd24ref', '1', 'assets/blog/1234567890/blog-details-1.jpg', NULL, 'Construction is facing a labor shortage – and it has been for a while. The statistics paint a discouraging picture, with an 8% drop in the number of construction workers aged 25-54 over the last decade. Moreover, one in five workers is over the age of 55, when the traditional age of retirement in the industry is 61. \r\n\r\nOverall, we’re looking at a total shortage of about 650,000 workers for 2022, and that’s assuming hiring otherwise continues apace. According to a recent survey, “Ninety-three percent of respondents say they have open positions that they’re trying to fill and 91% (up slightly from 90% in 2021) indicate they are struggling to fill at least some of these roles.” Nowhere is this truer than in craft roles, which comprise the majority of workforce employment. \r\n\r\nThis is most likely not new news to you. What you may not know is that we’ve got a secret weapon for helping to mitigate the labor shortage and improve productivity overall.  \r\n\r\nDEI (diversity, equity and inclusion) programs and practices help build a stronger and more resilient workforce to weather the labor shortage.  \r\n\r\nSo how are firms making this a reality, exactly? We asked real professionals in the Big Room to share their thoughts.  ', '[https://constructionblog.autodesk.com/addressing-labor-shortages-through-dei-overheard-in-the-big-room/] by Grace Ellis', '1234567890', '1,2', 100, '2022-10-25 13:16:51'),
(2, 'A Look Behind Constructing the Most Sustainable Building in the Southeast', '123sdw556624ref', '1', 'assets/blog/1255668890/like-post-2.jpg', NULL, 'The Living Building Challenge — an international building certification program that promotes advanced sustainability in construction — isn’t called a “challenge” for nothing.   It has the most rigorous sustainability standards. To be certified, buildings must meet all advanced sustainability measures in seven categories: place, water, energy, health, happiness, materials, equity, and beauty. Unlike Leadership and Energy Environmental Design (LEED), the Living Building Challenge is less about the building’s performance and more about the overall environmental impact of the facility. Certification is only given after one full year of continuous occupancy when the facility has proven it has achieved net positive energy, net positive water, and net positive waste.   Needless to say, it’s no easy feat.   That’s why we’re excited to spotlight the Kendeda Building for Innovative Sustainable Design, a 36,978-square-feet education and research facility that’s striving for full certification from the Living Building Challenge.   Recognized by Metro Atlanta as one of the most innovative projects in the Southeast, the Kendeda Building is a net-positive sustainable urban structure with a green roof, a solar panel canopy, cisterns for rainwater collection and reuse, and integrated plantings around the site to provide food for students throughout the year.  We recently caught up with Jimmy Mitchell, the Sustainability Engineer at Skanska USA, who worked on the project. Mitchell will be presenting at Autodesk University, where he will take the virtual stage for a session titled The Kendeda Building for Innovative Sustainable Design.   Register for AU 2020 to learn how the team overcame the project’s challenges and discover how collaboration and technology helped Mitchell and his team in all phases of construction — from preconstruction to turnover.  Ahead of the session, we chatted with Mitchell and asked him to walk us through his experience in sustainable construction and what people can expect to learn from his session. ', '[https://constructionblog.autodesk.com/sustainable-building-southeast-kendeda/] by Grace Ellis', '1255668890', '1,2', 500, '2022-10-25 13:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE `blog_comments` (
  `id` int(11) UNSIGNED NOT NULL,
  `postid` int(11) NOT NULL,
  `author` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blog_comments`
--

INSERT INTO `blog_comments` (`id`, `postid`, `author`, `comment`, `date_posted`) VALUES
(6, 2, 7755, 'wonderful post guys keep it up', '2021-12-04 16:00:02'),
(7, 1, 1210, 'Good post guys', '2022-10-25 13:23:13');

-- --------------------------------------------------------

--
-- Table structure for table `blog_replies`
--

CREATE TABLE `blog_replies` (
  `id` int(11) UNSIGNED NOT NULL,
  `commentid` int(11) DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blog_replies`
--

INSERT INTO `blog_replies` (`id`, `commentid`, `author`, `reply`, `date_posted`) VALUES
(5, 5, 8685, 'reply to second sample from reply page', '2021-12-04 15:49:44');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(500) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `email_slug` varchar(500) DEFAULT NULL,
  `roles` int(11) DEFAULT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `email`, `email_slug`, `roles`, `date_registered`) VALUES
(1, 'Admin', '12345', 'admin@wiscoprime.com', '1234567890', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) UNSIGNED NOT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `projectname` varchar(250) DEFAULT NULL,
  `clientname` varchar(500) DEFAULT NULL,
  `tags` varchar(11) DEFAULT NULL,
  `value` varchar(500) DEFAULT NULL,
  `year_comp` timestamp NULL DEFAULT NULL,
  `year_start` timestamp NULL DEFAULT NULL,
  `area` varchar(500) DEFAULT NULL,
  `architect` varchar(500) DEFAULT NULL,
  `location` varchar(500) DEFAULT NULL,
  `investor_web` varchar(500) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `details_file` varchar(500) DEFAULT NULL,
  `owner_review` varchar(500) DEFAULT NULL,
  `owner_rate` int(11) DEFAULT NULL,
  `cover` varchar(500) DEFAULT NULL,
  `thumbs` int(11) DEFAULT NULL,
  `date_posted` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `slug`, `projectname`, `clientname`, `tags`, `value`, `year_comp`, `year_start`, `area`, `architect`, `location`, `investor_web`, `summary`, `details_file`, `owner_review`, `owner_rate`, `cover`, `thumbs`, `date_posted`) VALUES
(1, '1234', 'Nasarawa Panda Project', 'Developer Test', '3,7,8', '1000000', '2021-12-04 16:00:02', '2020-12-04 16:00:02', '21,000 m2', 'Developer & Test', 'Nasarawa State, Nigeria', 'http://wiscoprimenl.com/', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lau-dantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi.', '1234', 'Excellent Job guys', 3, 'cover.png', 14, '2021-12-04 16:00:02'),
(2, '1235', 'Galadimawa Project', 'Developer Test', '3,8', '1000000', '2021-12-04 16:00:02', '2020-12-04 16:00:02', '21,000 m2', 'Developer & Test', 'Abuja Nigeria', 'http://wiscoprimenl.com/', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lau-dantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi.', '1235', 'Excellent Job guys', 3, 'cover.png', 11, '2021-12-04 16:00:02'),
(3, '1236', 'Akure Ondo State Project', 'Developer Test', '3,9', '1000000', '2021-12-04 16:00:02', '2020-12-04 16:00:02', '21,000 m2', 'Developer & Test', 'Ondo State, Nigeria', 'http://wiscoprimenl.com/', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lau-dantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi.', '1236', 'Excellent Job guys', 4, 'cover.png', 13, '2021-12-04 16:00:02'),
(4, '1237', 'MTN Office Enugu Project', 'Developer Test', '3,4,9', '1000000', '2021-12-04 16:00:02', '2020-12-04 16:00:02', '21,000 m2', 'Developer & Test', 'Enugu State, Nigeria', 'http://wiscoprimenl.com/', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lau-dantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi.', '1237', 'Excellent Job guys', 4, 'cover.png', 4, '2021-12-04 16:00:02'),
(5, '1238', 'Other Projects', 'Developer Test', '3,4,8,9', '1000000', '2021-12-04 16:00:02', '2020-12-04 16:00:02', '21,000 m2', 'Developer & Test', 'Nigeria', 'http://wiscoprimenl.com/', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lau-dantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi.', '1238', 'Excellent Job guys', 4, 'cover.png', 4, '2021-12-04 16:00:02');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(500) DEFAULT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'phone', '+ (234) - 8023253220'),
(2, 'address', 'Abuja, Nigeria'),
(3, 'working_hours', '08 AM - 10 PM'),
(4, 'mailto', 'wiscoprimenl@yahoo.com'),
(5, 'phone', '+ (234) - 08135960958'),
(6, 'aboutus', 'Wisco-Prime Nigeria Limited was formed by Young Nigerian professionals who have various experiences and was fully registered at corporate Affairs Matter Decree No. 1 of 1990 out of a keen desire of making positive contributions to the development of our country.\n\nOur Mission is to discover, access, evaluate and develop world class growth and procedure of construction and maintenance services required in the public and private sectors.\nTo continuosly improve in our quality and open communication in the conduct of our activities to meet and conform to the desired ethical, safety and environmental standards.'),
(7, 'staffs', '250'),
(8, 'houses_built', '560');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(250) NOT NULL DEFAULT '',
  `type` int(1) DEFAULT NULL,
  `date_posted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `type`, `date_posted`) VALUES
(1, 'engineering', 2, '2021-12-07 19:06:13'),
(2, 'construction', 2, '2021-12-07 19:06:16'),
(3, 'buildings', 1, '2021-12-07 19:05:22'),
(4, 'interior', 1, '2021-12-07 19:05:22'),
(5, 'design', 1, '2021-12-07 19:05:22'),
(7, 'piping', 1, '2022-10-25 12:07:53'),
(8, 'finished', 1, '2021-12-07 19:05:22'),
(9, 'ongoing', 1, '2021-12-07 19:05:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogposts`
--
ALTER TABLE `blogposts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_replies`
--
ALTER TABLE `blog_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogposts`
--
ALTER TABLE `blogposts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog_comments`
--
ALTER TABLE `blog_comments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `blog_replies`
--
ALTER TABLE `blog_replies`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
