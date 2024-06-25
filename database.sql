CREATE DATABASE vayathar_pasanga;



USE vayathar_pasanga;



CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY,email VARCHAR(100) UNIQUE NOT NULL,password VARCHAR(255) NOT NULL);



CREATE TABLE personal_details (user_id INT PRIMARY KEY,name VARCHAR(100),phone VARCHAR(15),dob DATE,address TEXT,gender ENUM('Male', 'Female', 'Other'),qualification VARCHAR(100),photo VARCHAR(255),FOREIGN KEY (user_id) REFERENCES users(id));



CREATE TABLE events (id INT AUTO_INCREMENT PRIMARY KEY,user_id INT,event_date DATE,event_title VARCHAR(255),event_description TEXT,FOREIGN KEY (user_id) REFERENCES users(id));



CREATE TABLE chat (id INT AUTO_INCREMENT PRIMARY KEY,user_id INT,message TEXT,sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE);

