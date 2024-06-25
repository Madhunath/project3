# User Data Web Application

This web application allows users to manage their personal information, membership details, events, and includes a chatbox feature. It is built using HTML, CSS, PHP, and MySQL, and is deployed on an AWS EC2 Linux instance.

## Features

- **Registration:** New users can create an account.
- **Login:** Secure login for registered users.
- **Personal Details:** Users can update their personal information.
- **Members:** Manage membership details (CRUD operations).
- **Events:** Add and manage upcoming events.
- **Chatbox:** Real-time messaging between users.

## Setup and Deployment

1. **Connect to Your EC2 Instance:**
   - SSH into your EC2 instance using your terminal or SSH client.

2. **Database Setup:**
   - Log into MySQL: `mysql -u your_username -p`
   - Create a database: `CREATE DATABASE your_database_name;`
   - Import the provided SQL file to set up tables and initial data: `mysql -u your_username -p your_database_name < path/to/database.sql`

3. **Configure PHP:**
   - Update `php.ini` if needed for PHP settings.

4. **Deploy Your Application:**
   - Upload your web application files to the `/var/www/html` directory on your EC2 instance.
   - Create a directory named uploads in the same path.
   - Set 777 permission to the uploads directory.

5. **Start Apache:**
   - Restart Apache to apply changes: `sudo service apache2 restart`

6. **Access Your Application:**
   - Open your web browser and navigate to your EC2 instance's public IP or domain name.

## Technologies Used

- **Frontend:** HTML, CSS
- **Backend:** PHP
- **Database:** MySQL
- **Deployment:** AWS EC2 Linux instance with Apache, PHP, and MySQL
