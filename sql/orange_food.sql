-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    failed_attempts INT DEFAULT 0,
    locked_until TIMESTAMP NULL,
    is_admin BOOLEAN DEFAULT FALSE
);

-- Recipes Table
CREATE TABLE recipes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    ingredients TEXT NOT NULL,
    instructions TEXT NOT NULL,
    cuisine_type VARCHAR(50),
    dietary_preference VARCHAR(50),
    difficulty ENUM('Easy', 'Medium', 'Hard') DEFAULT 'Medium',
    prep_time INT,
    cook_time INT,
    servings INT,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Community Cookbook Table
CREATE TABLE community_cookbook (
    id INT PRIMARY KEY AUTO_INCREMENT,
    recipe_id INT,
    user_id INT,
    tip TEXT,
    experience TEXT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Categories Table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    type ENUM('cuisine', 'dietary', 'difficulty') NOT NULL
);

-- Recipe-Category Junction Table
CREATE TABLE recipe_categories (
    recipe_id INT,
    category_id INT,
    PRIMARY KEY (recipe_id, category_id),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Contact Messages Table
CREATE TABLE contact_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Resources Table
CREATE TABLE resources (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    type ENUM('recipe_card', 'tutorial', 'video', 'infographic') NOT NULL,
    file_path VARCHAR(255),
    category VARCHAR(50),
    description TEXT,
    download_count INT DEFAULT 0
);