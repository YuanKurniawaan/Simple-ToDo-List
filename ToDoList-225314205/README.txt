# Made by YohanesYuan
# Second year Student in Sanata Dharma University

To-Do List Web Application Setup Guide (Using XAMPP)
Must Install : XAMPP, Your favorite Code Editor and Web Browser

Step 1
-Install XAMPP
-Open XAMPP
-Start Apache server and MySQL Database

Step 2
-Copy and paste this raw folder to the htdocs in your XAMPP installation folder

Step 3
-Import Database by going to your web browser and go to
    http://localhost/phpmyadmin/

-Create new database called 
    to-do-list

-Click import tab at the top, and choose to-do-list.sql file
provided in the project folder and dont forget to click GO

Step 4
To Access the to-do-list, Open your web browser and navigate 
    http://localhost/ToDoList-225314205/
MAKE SURE YOUR APACHE SERVER AND MYSQL DATABASE IS ENABLED / ON

Step 5
Enjoy your to do list Website! Happy Coding!


==  Database Structure ==
The MySQL database contains the following tables:

user Table
Column	    Type	        Description
id	        INT	            Primary Key, Auto Increment
username	VARCHAR(255)	Unique username for each user
password	VARCHAR(255)	Password (hashed) for authentication

tasks Table
Column	    Type	        Description
id	        INT	            Primary Key, Auto Increment
username	VARCHAR(255)	Username (foreign key to user table)
task	    TEXT	        Task description
completed	BOOLEAN	        Task completion status (true/false)