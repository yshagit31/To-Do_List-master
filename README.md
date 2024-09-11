# To-Do List Application

This is a **To-Do List Application** that interacts with a MySQL database using a PHP backend and an AngularJS frontend. The application allows users to create tasks, filter tasks based on their status, view task counts by priority, and delete tasks.

## Features

- **Add Tasks**: Users can add new tasks with a priority level (High, Medium, Low).
- **View Tasks**: The application retrieves tasks from a MySQL database and displays them.
- **Filter Tasks**: Tasks can be filtered based on their completion status (All, Pending, Completed).
- **Delete Tasks**: Users can delete tasks, and the change is reflected in the database.
- **Task Counts**: The app displays the number of tasks for each priority (High, Medium, Low).

## Prerequisites

- **PHP** (version 7.x or later)
- **MySQL/MariaDB**
- **AngularJS** (for the frontend)
- **Apache/Nginx** server (or any web server capable of running PHP)
- [Composer](https://getcomposer.org/) (if using additional PHP packages)

## Database Setup

1. **Create MySQL database and tasks table**:

```sql
CREATE DATABASE todolist;

USE todolist;

CREATE TABLE `tasks` (
  `task_id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `priority` VARCHAR(50) NOT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'pending',
  `created_at` DATETIME NOT NULL
);
```
