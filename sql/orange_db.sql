-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2026 at 05:47 PM
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
-- Database: `orange_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Breakfast', 'Morning meals to start your day right', '2026-01-05 14:55:07'),
(2, 'Lunch', 'Midday meals for energy', '2026-01-05 14:55:07'),
(3, 'Dinner', 'Evening meals and main courses', '2026-01-05 14:55:07'),
(4, 'Dessert', 'Sweet treats and desserts', '2026-01-05 14:55:07'),
(5, 'Vegetarian', 'Plant-based recipes', '2026-01-05 14:55:07'),
(6, 'Quick & Easy', 'Fast recipes for busy days', '2026-01-05 14:55:07'),
(7, 'Healthy', 'Nutritious and healthy options', '2026-01-05 14:55:07'),
(8, 'Italian', 'Authentic Italian cuisine', '2026-01-05 14:55:07'),
(9, 'Asian', 'Asian inspired dishes', '2026-01-05 14:55:07'),
(10, 'Mexican', 'Spicy Mexican flavors', '2026-01-05 14:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `community_posts`
--

CREATE TABLE `community_posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `post_type` enum('recipe','tip','question','review') DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `comments` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_posts`
--

INSERT INTO `community_posts` (`id`, `user_id`, `title`, `content`, `category`, `post_type`, `likes`, `comments`, `created_at`, `updated_at`) VALUES
(2, 2, 'Vegetarian Meal Prep Ideas', 'Looking for vegetarian meal prep ideas for the week', 'Meal Planning', 'question', 15, 12, '2026-01-05 14:55:08', '2026-01-05 14:55:08'),
(3, 3, 'My Chocolate Cake Secret', 'The secret to moist chocolate cake is adding coffee to the batter!', 'Baking', 'tip', 42, 18, '2026-01-05 14:55:08', '2026-01-05 14:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `created_at`) VALUES
(1, 'Alex Johnson', 'alex@email.com', 'Partnership Inquiry', 'Interested in partnering with Orange for a cooking event.', 0, '2026-01-05 14:55:08'),
(2, 'Maria Garcia', 'maria@email.com', 'Recipe Submission', 'I would like to submit my family recipe for consideration.', 0, '2026-01-05 14:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  `cooking_time` int(11) DEFAULT NULL,
  `servings` int(11) DEFAULT NULL,
  `difficulty_level` enum('Easy','Medium','Hard') DEFAULT NULL,
  `cuisine_type` varchar(50) DEFAULT NULL,
  `dietary_preference` varchar(50) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `title`, `description`, `ingredients`, `instructions`, `cooking_time`, `servings`, `difficulty_level`, `cuisine_type`, `dietary_preference`, `featured_image`, `views`, `is_featured`, `created_at`, `updated_at`) VALUES
(2, 2, 'Avocado Toast with Poached Eggs', 'Healthy breakfast with creamy avocado and perfectly poached eggs', 'Bread, avocado, eggs, lemon juice, red pepper flakes, salt, pepper', '1. Toast bread. 2. Mash avocado with lemon juice. 3. Poach eggs for 3-4 minutes. 4. Spread avocado on toast. 5. Top with poached eggs. 6. Season with salt, pepper, and red pepper flakes.', 15, 2, 'Easy', 'American', 'Vegetarian', 'uploads/recipes/recipe_1767714919_695d306747048.jpg', 0, 1, '2026-01-05 14:55:08', '2026-01-06 15:55:19'),
(3, 3, 'Chocolate Lava Cake', 'Decadent chocolate cake with a molten center', 'Dark chocolate, butter, eggs, sugar, flour, cocoa powder', '1. Preheat oven to 425°F (220°C). 2. Melt chocolate and butter. 3. Whisk eggs and sugar. 4. Combine all ingredients. 5. Bake for 12-14 minutes. 6. Serve immediately.', 25, 4, 'Medium', 'French', 'Vegetarian', 'uploads/recipes/recipe_1767714990_695d30ae65421.jpg', 0, 1, '2026-01-05 14:55:08', '2026-01-06 15:56:30'),
(5, 2, 'Greek Salad', 'Fresh Mediterranean salad with feta cheese', 'Cucumber, tomatoes, red onion, olives, feta cheese, olive oil, oregano', '1. Chop vegetables. 2. Combine in bowl. 3. Add olives and feta. 4. Dress with olive oil and oregano. 5. Season with salt and pepper.', 15, 4, 'Easy', 'Mediterranean', 'Vegetarian', 'uploads/recipes/recipe_1767715035_695d30db7d534.jpg', 0, 1, '2026-01-05 14:55:08', '2026-01-06 15:57:15'),
(6, 3, 'Beef Burger', 'Juicy homemade burger with all the fixings', 'Ground beef, burger buns, lettuce, tomato, onion, cheese, pickles', '1. Form beef patties. 2. Season with salt and pepper. 3. Grill for 4-5 minutes per side. 4. Toast buns. 5. Assemble with toppings.', 20, 4, 'Easy', 'American', 'Non-Vegetarian', 'uploads/recipes/recipe_1767715094_695d311692a47.jpg', 0, 1, '2026-01-05 14:55:08', '2026-01-06 15:58:14'),
(8, 2, 'Pasta Carbonara', 'Classic Roman pasta dish', 'Spaghetti, eggs, pancetta, parmesan cheese, black pepper', '1. Cook pasta. 2. Fry pancetta. 3. Whisk eggs and cheese. 4. Combine hot pasta with egg mixture. 5. Add pancetta and pepper.', 25, 4, 'Medium', 'Italian', 'Non-Vegetarian', 'uploads/recipes/recipe_1767715156_695d315471704.jpg', 0, 0, '2026-01-05 14:55:08', '2026-01-06 15:59:16'),
(9, 3, 'Banana Bread', 'Moist and delicious banana bread', 'Ripe bananas, flour, sugar, eggs, butter, baking soda, vanilla', '1. Mash bananas. 2. Mix wet ingredients. 3. Add dry ingredients. 4. Pour into loaf pan. 5. Bake at 350°F for 60 minutes.', 75, 8, 'Easy', 'American', 'Vegetarian', 'uploads/recipes/recipe_1767715205_695d3185a5efc.jpg', 0, 0, '2026-01-05 14:55:08', '2026-01-06 16:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_categories`
--

CREATE TABLE `recipe_categories` (
  `recipe_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_categories`
--

INSERT INTO `recipe_categories` (`recipe_id`, `category_id`) VALUES
(2, 1),
(2, 7),
(3, 4),
(3, 6),
(5, 5),
(5, 7),
(6, 3),
(6, 6),
(8, 3),
(8, 8),
(9, 1),
(9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `recipe_comments`
--

CREATE TABLE `recipe_comments` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_comments`
--

INSERT INTO `recipe_comments` (`id`, `recipe_id`, `user_id`, `parent_id`, `comment`, `created_at`) VALUES
(3, 2, 3, NULL, 'Can I use regular bread instead of sourdough?', '2026-01-05 14:55:08'),
(5, 3, 3, NULL, 'Use high-quality dark chocolate for best results.', '2026-01-05 14:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_likes`
--

CREATE TABLE `recipe_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_likes`
--

INSERT INTO `recipe_likes` (`id`, `user_id`, `recipe_id`, `created_at`) VALUES
(4, 2, 2, '2026-01-05 14:55:08'),
(6, 2, 6, '2026-01-05 14:55:08'),
(9, 3, 9, '2026-01-05 14:55:08'),
(11, 2, 8, '2026-01-05 14:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_reviews`
--

CREATE TABLE `recipe_reviews` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_reviews`
--

INSERT INTO `recipe_reviews` (`id`, `recipe_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(4, 3, 2, 5, 'The lava cake was amazing! Everyone loved it.', '2026-01-05 14:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `resource_type` enum('recipe_card','tutorial','video','infographic','guide') DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `download_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `title`, `description`, `resource_type`, `file_path`, `download_count`, `created_at`) VALUES
(1, 'Weekly Meal Planner', 'Plan your meals for the week with this printable template', 'recipe_card', NULL, 156, '2026-01-05 14:55:08'),
(2, 'Recipe Card Template', 'Beautiful printable recipe cards for your kitchen', 'recipe_card', NULL, 89, '2026-01-05 14:55:08'),
(3, 'Grocery Shopping List', 'Organized shopping list template for your kitchen needs', 'recipe_card', NULL, 203, '2026-01-05 14:55:08'),
(4, 'Cooking Temperature Guide', 'Safe cooking temperatures for different types of food', 'guide', NULL, 127, '2026-01-05 14:55:08'),
(5, 'Seasonal Cooking Guide', 'What fruits and vegetables are in season each month', 'guide', NULL, 94, '2026-01-05 14:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `resource_downloads`
--

CREATE TABLE `resource_downloads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `resource_name` varchar(255) NOT NULL,
  `download_count` int(11) DEFAULT 1,
  `last_downloaded` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resource_downloads`
--

INSERT INTO `resource_downloads` (`id`, `user_id`, `resource_id`, `resource_name`, `download_count`, `last_downloaded`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 5, 0, 'Weekly Meal Planner.pdf', 1, '2026-01-06 16:40:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 16:40:10'),
(2, 5, 0, 'Recipe Card Template.pdf', 1, '2026-01-06 16:40:30', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 16:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `saved_recipes`
--

CREATE TABLE `saved_recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `saved_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved_recipes`
--

INSERT INTO `saved_recipes` (`id`, `user_id`, `recipe_id`, `saved_at`) VALUES
(6, 2, 6, '2026-01-05 14:55:08'),
(9, 3, 9, '2026-01-05 14:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `failed_attempts` int(11) DEFAULT 0,
  `locked_until` datetime DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `bio`, `failed_attempts`, `locked_until`, `is_admin`, `created_at`, `updated_at`) VALUES
(2, 'Sarah', 'Foodie', 'sarah@orange.com', '$2y$10$YourHashedPasswordHere', 'Home cook passionate about healthy meals', 0, NULL, 0, '2026-01-05 14:55:07', '2026-01-05 14:55:07'),
(3, 'Mike', 'Baker', 'mike@orange.com', '$2y$10$YourHashedPasswordHere', 'Pastry chef specializing in desserts', 0, NULL, 0, '2026-01-05 14:55:07', '2026-01-05 14:55:07'),
(4, 'Admin', 'User', 'admin@orange.com', '$2y$10$gDtDhzwrF6u2hB8s2q0mE.CtiHDFg5MPduAdiDIS//eRCpfgBO7Xi', 'System administrator', 0, NULL, 1, '2026-01-05 14:55:07', '2026-01-05 16:21:49'),
(5, 'user', 'food', 'user@foodfusion.com', '$2y$10$gDtDhzwrF6u2hB8s2q0mE.CtiHDFg5MPduAdiDIS//eRCpfgBO7Xi', NULL, 0, NULL, 0, '2026-01-05 15:56:07', '2026-01-05 17:37:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_is_read` (`is_read`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_featured` (`is_featured`);

--
-- Indexes for table `recipe_categories`
--
ALTER TABLE `recipe_categories`
  ADD PRIMARY KEY (`recipe_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `recipe_comments`
--
ALTER TABLE `recipe_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_recipe_id` (`recipe_id`),
  ADD KEY `idx_parent_id` (`parent_id`);

--
-- Indexes for table `recipe_likes`
--
ALTER TABLE `recipe_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_recipe_like` (`user_id`,`recipe_id`),
  ADD KEY `idx_recipe_id` (`recipe_id`);

--
-- Indexes for table `recipe_reviews`
--
ALTER TABLE `recipe_reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_recipe` (`user_id`,`recipe_id`),
  ADD KEY `idx_recipe_id` (`recipe_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_rating` (`rating`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_resource_type` (`resource_type`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `resource_downloads`
--
ALTER TABLE `resource_downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_resource_name` (`resource_name`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `saved_recipes`
--
ALTER TABLE `saved_recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_recipe` (`user_id`,`recipe_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_recipe_id` (`recipe_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `community_posts`
--
ALTER TABLE `community_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `recipe_comments`
--
ALTER TABLE `recipe_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `recipe_likes`
--
ALTER TABLE `recipe_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `recipe_reviews`
--
ALTER TABLE `recipe_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `resource_downloads`
--
ALTER TABLE `resource_downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `saved_recipes`
--
ALTER TABLE `saved_recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `community_posts`
--
ALTER TABLE `community_posts`
  ADD CONSTRAINT `community_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_categories`
--
ALTER TABLE `recipe_categories`
  ADD CONSTRAINT `recipe_categories_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_comments`
--
ALTER TABLE `recipe_comments`
  ADD CONSTRAINT `recipe_comments_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_comments_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `recipe_comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_likes`
--
ALTER TABLE `recipe_likes`
  ADD CONSTRAINT `recipe_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_likes_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_reviews`
--
ALTER TABLE `recipe_reviews`
  ADD CONSTRAINT `recipe_reviews_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `resource_downloads`
--
ALTER TABLE `resource_downloads`
  ADD CONSTRAINT `resource_downloads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_recipes`
--
ALTER TABLE `saved_recipes`
  ADD CONSTRAINT `saved_recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_recipes_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
