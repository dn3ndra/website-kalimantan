-- Create the database
CREATE DATABASE organization_db;
USE organization_db;

-- Team members table
CREATE TABLE team_members (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    position VARCHAR(100) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    bio TEXT,
    linkedin_url VARCHAR(255),
    twitter_url VARCHAR(255),
    instagram_url VARCHAR(255),
    order_number INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- News/Events table
CREATE TABLE news (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    event_date DATE,
    excerpt TEXT,
    slug VARCHAR(255) UNIQUE,
    is_published BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Testimonials table
CREATE TABLE testimonials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    author_name VARCHAR(100) NOT NULL,
    author_position VARCHAR(100),
    image_path VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Slider images table
CREATE TABLE slider_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    image_path VARCHAR(255) NOT NULL,
    caption TEXT,
    order_number INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample team members
INSERT INTO team_members (name, position, image_path, email, bio, linkedin_url, twitter_url, instagram_url, order_number) VALUES 
('John Doe', 'President', 'images/team/member1.jpg', 'john@example.com', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'https://linkedin.com/in/johndoe', 'https://twitter.com/johndoe', 'https://instagram.com/johndoe', 1),
('Jane Smith', 'Vice President', 'images/team/member2.jpg', 'jane@example.com', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'https://linkedin.com/in/janesmith', 'https://twitter.com/janesmith', 'https://instagram.com/janesmith', 2),
('Mike Johnson', 'Secretary', 'images/team/member3.jpg', 'mike@example.com', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco.', 'https://linkedin.com/in/mikejohnson', 'https://twitter.com/mikejohnson', 'https://instagram.com/mikejohnson', 3);

-- Insert sample slider images
INSERT INTO slider_images (title, image_path, caption, order_number) VALUES 
('Welcome Slide', 'slider/slide1.jpg', 'Welcome to our organization', 1),
('Events Slide', 'slider/slide2.jpg', 'Join our upcoming events', 2),
('Community Slide', 'slider/slide3.jpg', 'Be part of our community', 3);

-- Insert sample testimonials
INSERT INTO testimonials (author_name, author_position, image_path, content, rating) VALUES 
('Sarah Wilson', 'Student Leader', 'images/testimonials/testimonial1.jpg', 'This organization has transformed my college experience!', 5),
('David Brown', 'Alumni', 'images/testimonials/testimonial2.jpg', 'The leadership opportunities here are incredible.', 5),
('Emily Davis', 'Member', 'images/testimonials/testimonial3.jpg', 'Great community and amazing learning experience.', 4);

-- Insert sample news/events
INSERT INTO news (title, content, image_path, event_date, excerpt, slug) VALUES 
('Annual Leadership Conference', 'Full content of the leadership conference...', 'images/news/event1.jpg', '2024-03-15', 'Join us for our annual leadership conference featuring renowned speakers...', 'annual-leadership-conference-2024'),
('Community Service Day', 'Full content of the community service day...', 'images/news/event2.jpg', '2024-04-20', 'Help us make a difference in our community...', 'community-service-day-2024'),
('Workshop Series', 'Full content of the workshop series...', 'images/news/event3.jpg', '2024-05-01', 'Learn new skills with our expert-led workshop series...', 'workshop-series-2024'); 