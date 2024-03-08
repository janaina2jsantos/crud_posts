SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
DROP database IF EXISTS cms;
CREATE DATABASE cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
use cms;

-- ========================================================
--
-- Table `users`
--
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL, -- 123456
  `role` int(11) DEFAULT 1,
  `token` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `token`, `active`, `created_at`, `updated_at`) 
VALUES (1, 'Admin', 'admin@admin.com', '$2y$10$zyH8rvvxD6lJ/b9OLiXeX.OFFA42Fna4NE6QDOYRAMJXr3dDeVVxO', 1, 'token_629309c56f123', 1, '2024-02-27 04:29:55', '2024-02-27 04:29:55');

-- ========================================================
--
-- Table `posts`
--
CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `image` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `posts` (`id`, `title`, `content`, `status`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Finding Great Coffee in Ho Chi Minh City', '<p>Other than Brazil, no nation produces more coffee than\ 
  Vietnam. Introduced by French colonists in the 19th century, the country’s coffee crop is now a $3 billion\ 
  business and accounts for nearly 15 percent of the global market, making Vietnam the java giant of Southeast\ 
  Asia.<br /><br />Quality, however, has only recently begun to catch up with quantity, mainly because farmers have begun\ 
  augmenting Vietnam’s longtime cultivation of cheaper, easy-to-grow robusta beans with a connoisseur’s\ 
  favorite, arabica.<p/><iframe width="560" height="315" src="https://www.youtube.com/embed/3xdnZS0NHkY?si=ir6ZBFiyzdXeJIci"\ 
  title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media;\ 
  gyroscope; picture-in-picture; web-share" allowfullscreen></iframe><p>A major beneficiary has been the cafe scene in the country’s largest metropolis, Ho Chi\ 
  Minh City (a.k.a. Saigon).<br /><br />Thanks to direct crop-to-shop supplies, the retail business of coffee is booming\ 
  as increasing numbers of indie roasteries and specialty coffeehouses sprout up around the city’s French\ 
  colonial opera house, amid the megamalls and boutiques of fashionable Dong Khoi Boulevard, and in the\ 
  shadows of the high-rise towers in District 2.</p>', 1, '/uploads/posts/post01.jpg', '2024-02-27 01:49:33', '2024-02-27 04:29:55', NULL),

(2, 'Review: Dancing Out ‘Goldberg’ With a Nod to John Travolta', '<p>Images of women testing their\ 
  bodies’ endurance have been swirling about the universe lately. There are pop stars like Madonna whose\ 
  touring shows, as TikTok attests, shine a light on presence and physicality as these artists sing and dance,\ 
  exploring the limits of what their bodies can and cannot do.<br /><br />And then there is the contemporary choreographer\ 
  and dancer Anne Teresa De Keersmaeker who, at 63, is pushing her body, too, in a solo lasting nearly two hours.
  For “The Goldberg Variations, BWV 988,” De Keersmaeker is joined by the young Russian-born pianist\ 
  Pavel Kolesnikov. There are costume changes — for both — and a spare setting dominated by foil.<br /><br />On paper,\ 
  De Keersmaeker’s version of “Goldberg Variations” is a solo. Onstage, it veers into duet territory. She needs\ 
  Kolesnikov, and not just for his exceptional skills at the piano. When her physicality can feel distant and\ 
  contained — a hybrid of deadpan and highbrow — his boyish energy gives her something to bounce off, allowing\ 
  a less stoic side to slip through. In one such moment, she pushes him off his bench. His gentle dismay\ 
  is adorable.</p>', 1, '/uploads/posts/post02.jpg', '2024-02-27 01:49:33', '2024-02-27 04:29:55', NULL),

(3, 'Jeff Bezos’ Big Rocket Moves Into View and Closer to Launch', '<p>There’s an easy knock against the space\ 
  dreams of Jeff Bezos and his rocket company, Blue Origin: In its 24th year of existence, the company has yet
  to launch a single thing to orbit.<br /><br />Blue Origin’s accomplishments to date are modest — a small vehicle known\ 
  as New Shepard that takes space tourists and experiments on brief suborbital jaunts. By contrast, SpaceX,\ 
  the rocket company started by the other high-profile space billionaire, Elon Musk, today dominates the launch
  market.<br /><br />On Wednesday, Blue Origin hopes to change the narrative, holding a coming-out party of sorts\ 
  for its new big rocket.<br /><br />In the morning, at Launch Complex 36 at the Cape Canaveral Space Force\ 
  Station in Florida, the doors to a giant garage opened. The rocket, as tall as a 32-story building,\ 
  lay horizontally on the trusses of a mobile launch platform.</p>', 1, '/uploads/posts/post03.jpg', '2024-02-27 01:49:33', '2024-02-27 04:29:55', NULL);