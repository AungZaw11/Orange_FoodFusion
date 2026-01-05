-- Orange Database with Dummy Data
CREATE DATABASE IF NOT EXISTS orange_db;
USE orange_db;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_image VARCHAR(255),
    bio TEXT,
    failed_attempts INT DEFAULT 0,
    locked_until DATETIME,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Recipes table
CREATE TABLE recipes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    ingredients TEXT NOT NULL,
    instructions TEXT NOT NULL,
    cooking_time INT,
    servings INT,
    difficulty_level ENUM('Easy', 'Medium', 'Hard'),
    cuisine_type VARCHAR(50),
    dietary_preference VARCHAR(50),
    featured_image VARCHAR(255),
    views INT DEFAULT 0,
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at),
    INDEX idx_featured (is_featured)
);

-- Categories table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Recipe Categories (Junction Table)
CREATE TABLE recipe_categories (
    recipe_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (recipe_id, category_id),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Community Posts table
CREATE TABLE community_posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50),
    post_type ENUM('recipe', 'tip', 'question', 'review'),
    likes INT DEFAULT 0,
    comments INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_category (category),
    INDEX idx_created_at (created_at)
);

-- Recipe Reviews table
CREATE TABLE recipe_reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recipe_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_recipe (user_id, recipe_id),
    INDEX idx_recipe_id (recipe_id),
    INDEX idx_user_id (user_id),
    INDEX idx_rating (rating)
);

-- Resources table
CREATE TABLE resources (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    resource_type ENUM('recipe_card', 'tutorial', 'video', 'infographic', 'guide'),
    file_path VARCHAR(255),
    download_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_resource_type (resource_type),
    INDEX idx_created_at (created_at)
);

-- Contact Messages table
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_created_at (created_at),
    INDEX idx_is_read (is_read)
);

-- Saved Recipes table
CREATE TABLE saved_recipes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    recipe_id INT NOT NULL,
    saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_recipe (user_id, recipe_id),
    INDEX idx_user_id (user_id),
    INDEX idx_recipe_id (recipe_id)
);

-- Recipe Likes table
CREATE TABLE recipe_likes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    recipe_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_recipe_like (user_id, recipe_id),
    INDEX idx_recipe_id (recipe_id)
);

-- Recipe Comments table
CREATE TABLE recipe_comments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recipe_id INT NOT NULL,
    user_id INT NOT NULL,
    parent_id INT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES recipe_comments(id) ON DELETE CASCADE,
    INDEX idx_recipe_id (recipe_id),
    INDEX idx_parent_id (parent_id)
);

-- ===========================================
-- DUMMY DATA INSERTION
-- ===========================================

-- Insert sample users (password for all: Password123!)
INSERT INTO users (first_name, last_name, email, password, profile_image, bio, is_admin) VALUES
('John', 'Chefmaster', 'john@orange.com', '$2y$10$YourHashedPasswordHere', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=400&fit=crop', 'Professional chef with 10+ years experience. Love sharing recipes!', FALSE),
('Sarah', 'Foodie', 'sarah@orange.com', '$2y$10$YourHashedPasswordHere', 'https://images.unsplash.com/photo-1494790108755-2616b786d4d5?w=400&h=400&fit=crop', 'Home cook passionate about healthy meals', FALSE),
('Mike', 'Baker', 'mike@orange.com', '$2y$10$YourHashedPasswordHere', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop', 'Pastry chef specializing in desserts', FALSE),
('Admin', 'User', 'admin@orange.com', '$2y$10$YourHashedPasswordHere', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=400&fit=crop', 'System administrator', TRUE);

-- Insert categories
INSERT INTO categories (name, description) VALUES
('Breakfast', 'Morning meals to start your day right'),
('Lunch', 'Midday meals for energy'),
('Dinner', 'Evening meals and main courses'),
('Dessert', 'Sweet treats and desserts'),
('Vegetarian', 'Plant-based recipes'),
('Quick & Easy', 'Fast recipes for busy days'),
('Healthy', 'Nutritious and healthy options'),
('Italian', 'Authentic Italian cuisine'),
('Asian', 'Asian inspired dishes'),
('Mexican', 'Spicy Mexican flavors');

-- Insert recipes with Unsplash images
INSERT INTO recipes (user_id, title, description, ingredients, instructions, cooking_time, servings, difficulty_level, cuisine_type, dietary_preference, featured_image, is_featured) VALUES
(1, 'Classic Margherita Pizza', 'Traditional Italian pizza with fresh basil and mozzarella', 'Pizza dough, tomato sauce, fresh mozzarella, basil leaves, olive oil, salt', '1. Preheat oven to 475°F (245°C). 2. Roll out pizza dough. 3. Spread tomato sauce. 4. Add mozzarella slices. 5. Bake for 12-15 minutes. 6. Top with fresh basil.', 30, 4, 'Easy', 'Italian', 'Vegetarian', 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800&h=600&fit=crop', 1),
(2, 'Avocado Toast with Poached Eggs', 'Healthy breakfast with creamy avocado and perfectly poached eggs', 'Bread, avocado, eggs, lemon juice, red pepper flakes, salt, pepper', '1. Toast bread. 2. Mash avocado with lemon juice. 3. Poach eggs for 3-4 minutes. 4. Spread avocado on toast. 5. Top with poached eggs. 6. Season with salt, pepper, and red pepper flakes.', 15, 2, 'Easy', 'American', 'Vegetarian', 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=800&h=600&fit=crop', 1),
(3, 'Chocolate Lava Cake', 'Decadent chocolate cake with a molten center', 'Dark chocolate, butter, eggs, sugar, flour, cocoa powder', '1. Preheat oven to 425°F (220°C). 2. Melt chocolate and butter. 3. Whisk eggs and sugar. 4. Combine all ingredients. 5. Bake for 12-14 minutes. 6. Serve immediately.', 25, 4, 'Medium', 'French', 'Vegetarian', 'https://images.unsplash.com/photo-1623334044303-241021148842?w=800&h=600&fit=crop', 1),
(1, 'Chicken Tikka Masala', 'Creamy Indian curry with grilled chicken', 'Chicken, yogurt, cream, tomatoes, spices, garlic, ginger', '1. Marinate chicken in yogurt and spices. 2. Grill chicken. 3. Make tomato-based curry sauce. 4. Add cream and grilled chicken. 5. Simmer for 10 minutes. 6. Garnish with cilantro.', 45, 4, 'Medium', 'Indian', 'Non-Vegetarian', 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=800&h=600&fit=crop', 1),
(2, 'Greek Salad', 'Fresh Mediterranean salad with feta cheese', 'Cucumber, tomatoes, red onion, olives, feta cheese, olive oil, oregano', '1. Chop vegetables. 2. Combine in bowl. 3. Add olives and feta. 4. Dress with olive oil and oregano. 5. Season with salt and pepper.', 15, 4, 'Easy', 'Mediterranean', 'Vegetarian', 'https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=800&h=600&fit=crop', 1),
(3, 'Beef Burger', 'Juicy homemade burger with all the fixings', 'Ground beef, burger buns, lettuce, tomato, onion, cheese, pickles', '1. Form beef patties. 2. Season with salt and pepper. 3. Grill for 4-5 minutes per side. 4. Toast buns. 5. Assemble with toppings.', 20, 4, 'Easy', 'American', 'Non-Vegetarian', 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800&h=600&fit=crop', 1),
(1, 'Vegetable Stir Fry', 'Quick and healthy vegetable stir fry', 'Mixed vegetables, tofu, soy sauce, garlic, ginger, sesame oil', '1. Chop vegetables. 2. Heat oil in wok. 3. Add garlic and ginger. 4. Stir-fry vegetables. 5. Add tofu and sauce. 6. Cook until tender.', 20, 4, 'Easy', 'Asian', 'Vegan', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800&h=600&fit=crop', 0),
(2, 'Pasta Carbonara', 'Classic Roman pasta dish', 'Spaghetti, eggs, pancetta, parmesan cheese, black pepper', '1. Cook pasta. 2. Fry pancetta. 3. Whisk eggs and cheese. 4. Combine hot pasta with egg mixture. 5. Add pancetta and pepper.', 25, 4, 'Medium', 'Italian', 'Non-Vegetarian', 'https://images.unsplash.com/photo-1598866594230-a7c12756260f?w=800&h=600&fit=crop', 0),
(3, 'Banana Bread', 'Moist and delicious banana bread', 'Ripe bananas, flour, sugar, eggs, butter, baking soda, vanilla', '1. Mash bananas. 2. Mix wet ingredients. 3. Add dry ingredients. 4. Pour into loaf pan. 5. Bake at 350°F for 60 minutes.', 75, 8, 'Easy', 'American', 'Vegetarian', 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?w=800&h=600&fit=crop', 0),
(1, 'Guacamole', 'Fresh Mexican avocado dip', 'Avocados, lime juice, onion, tomato, cilantro, jalapeno, salt', '1. Mash avocados. 2. Chop vegetables. 3. Mix all ingredients. 4. Add lime juice and salt. 5. Serve with tortilla chips.', 15, 6, 'Easy', 'Mexican', 'Vegan', 'https://images.unsplash.com/photo-1562059390-a761a084768e?w=800&h=600&fit=crop', 0);

-- Insert recipe categories
INSERT INTO recipe_categories (recipe_id, category_id) VALUES
(1, 8), (1, 4), -- Pizza: Italian, Dinner
(2, 1), (2, 7), -- Avocado Toast: Breakfast, Healthy
(3, 4), (3, 6), -- Chocolate Cake: Dessert, Quick & Easy
(4, 10), (4, 3), -- Chicken Tikka: Indian, Dinner
(5, 7), (5, 5), -- Greek Salad: Healthy, Vegetarian
(6, 3), (6, 6), -- Burger: Dinner, Quick & Easy
(7, 7), (7, 5), -- Stir Fry: Healthy, Vegetarian
(8, 8), (8, 3), -- Pasta: Italian, Dinner
(9, 1), (9, 4), -- Banana Bread: Breakfast, Dessert
(10, 10), (10, 5); -- Guacamole: Mexican, Vegetarian

-- Insert community posts
INSERT INTO community_posts (user_id, title, content, category, post_type, likes, comments) VALUES
(1, 'Best Pizza Dough Recipe', 'After years of experimenting, I found the perfect pizza dough recipe!', 'Cooking Tips', 'tip', 24, 8),
(2, 'Vegetarian Meal Prep Ideas', 'Looking for vegetarian meal prep ideas for the week', 'Meal Planning', 'question', 15, 12),
(3, 'My Chocolate Cake Secret', 'The secret to moist chocolate cake is adding coffee to the batter!', 'Baking', 'tip', 42, 18),
(1, 'Indian Spice Guide', 'Complete guide to essential Indian spices for beginners', 'Cooking Basics', 'guide', 31, 9);

-- Insert recipe reviews
INSERT INTO recipe_reviews (recipe_id, user_id, rating, comment) VALUES
(1, 2, 5, 'Best pizza I ever made! The crust was perfect.'),
(1, 3, 4, 'Great recipe, but I added some extra garlic.'),
(2, 1, 5, 'Perfect breakfast! So healthy and delicious.'),
(3, 2, 5, 'The lava cake was amazing! Everyone loved it.'),
(4, 3, 4, 'Authentic taste, though a bit spicy for my family.');

-- Insert resources
INSERT INTO resources (title, description, resource_type, download_count) VALUES
('Weekly Meal Planner', 'Plan your meals for the week with this printable template', 'recipe_card', 156),
('Recipe Card Template', 'Beautiful printable recipe cards for your kitchen', 'recipe_card', 89),
('Grocery Shopping List', 'Organized shopping list template for your kitchen needs', 'recipe_card', 203),
('Cooking Temperature Guide', 'Safe cooking temperatures for different types of food', 'guide', 127),
('Seasonal Cooking Guide', 'What fruits and vegetables are in season each month', 'guide', 94);

-- Insert saved recipes
INSERT INTO saved_recipes (user_id, recipe_id) VALUES
(1, 2), (1, 3), (1, 5),
(2, 1), (2, 4), (2, 6),
(3, 1), (3, 7), (3, 9);

-- Insert recipe likes
INSERT INTO recipe_likes (user_id, recipe_id) VALUES
(1, 1), (1, 3), (1, 5),
(2, 2), (2, 4), (2, 6),
(3, 1), (3, 7), (3, 9),
(1, 7), (2, 8), (3, 10);

-- Insert recipe comments
INSERT INTO recipe_comments (recipe_id, user_id, comment) VALUES
(1, 2, 'How long should I let the dough rise?'),
(1, 1, 'Let it rise for at least 2 hours for best results.'),
(2, 3, 'Can I use regular bread instead of sourdough?'),
(3, 1, 'What type of chocolate works best?'),
(3, 3, 'Use high-quality dark chocolate for best results.');

-- Insert contact messages
INSERT INTO contact_messages (name, email, subject, message) VALUES
('Alex Johnson', 'alex@email.com', 'Partnership Inquiry', 'Interested in partnering with Orange for a cooking event.'),
('Maria Garcia', 'maria@email.com', 'Recipe Submission', 'I would like to submit my family recipe for consideration.');

-- Show table counts
SELECT 
    'users' as table_name, COUNT(*) as count FROM users
UNION ALL
SELECT 'recipes', COUNT(*) FROM recipes
UNION ALL
SELECT 'categories', COUNT(*) FROM categories
UNION ALL
SELECT 'community_posts', COUNT(*) FROM community_posts
UNION ALL
SELECT 'recipe_reviews', COUNT(*) FROM recipe_reviews
UNION ALL
SELECT 'resources', COUNT(*) FROM resources;