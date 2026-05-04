# 📌 Smart Productivity Planner

### Built with PHP & MySQL --- Simple Task Management Web App

------------------------------------------------------------------------

## 📁 Project Structure

    smart_productivity_planner/
    │
    ├── index.php           ← Admin Login Page
    ├── description.php     ← Project intro / landing page after login
    ├── toodoo.php          ← Main planner (task CRUD + stats + filter)
    ├── MYREADME.md         ← Project documentation

------------------------------------------------------------------------

## ⚙️ Setup Instructions (XAMPP)

### Step 1: Copy Project

Place your project folder inside:

    C:\xampp\htdocs\smart_productivity_planner

------------------------------------------------------------------------

### Step 2: Create Database

1.  Open browser → go to `http://localhost/phpmyadmin`
2.  Click **New**
3.  Create database named:

```{=html}
    todo_project

------------------------------------------------------------------------

### Step 3: Create Tables

Go to `todo_project` → click **SQL** tab → run the following:

#### Create `tasks` table:

``` sql
CREATE TABLE tasks (
  id int(11) NOT NULL AUTO_INCREMENT,
  task_name varchar(255) NOT NULL,
  task_date date NOT NULL,
  task_time time NOT NULL,
  priority varchar(50) NOT NULL,
  status varchar(50) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

#### Create `users` table + insert admin:

``` sql
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (username, password) VALUES ('admin', 'password123');
```

Click **Go** after running each query.

------------------------------------------------------------------------

### Step 4: Start XAMPP

Start: - Apache\
- MySQL

------------------------------------------------------------------------

### Step 5: Run the Project

Open browser:

    http://localhost/smart_productivity_planner/

------------------------------------------------------------------------

### Step 6: Login Credentials

    Username: admin  
    Password: password123

------------------------------------------------------------------------

## 🗃️ Database Tables

  Table   Purpose
  ------- --------------------------------------------------------
  users   Stores admin login credentials
  tasks   Stores all tasks with date, time, priority, and status

------------------------------------------------------------------------

## 📋 Modules Explained

### 1. Admin Login (`index.php`)

-   Displays login form\
-   Verifies username & password from database\
-   Creates session on successful login\
-   Redirects to description page\
-   Shows error on invalid login

------------------------------------------------------------------------

### 2. Description Page (`description.php`)

-   Displays project overview\
-   Accessible only after login (session protected)\
-   Button to launch main planner\
-   Logout option available

------------------------------------------------------------------------

### 3. Task Manager (`toodoo.php`)

#### ➤ Add / Update Task

-   User can add task with:
    -   Title\
    -   Date\
    -   Time\
    -   Priority\
-   Same form is used for editing existing tasks

------------------------------------------------------------------------

#### ➤ Task Actions

-   **Done** → marks task as completed\
-   **Undo** → changes back to pending\
-   **Delete** → removes task permanently\
-   **Edit** → loads task data into form

------------------------------------------------------------------------

#### ➤ Statistics

-   Displays:
    -   Total Tasks\
    -   Completed Tasks\
    -   Pending Tasks\
-   Values update dynamically from database

------------------------------------------------------------------------

#### ➤ Filtering

-   Filter tasks by priority:
    -   High\
    -   Medium\
    -   Low\
-   Implemented using JavaScript

------------------------------------------------------------------------

#### ➤ Task Display

-   Tasks shown in table format\
-   Sorted by:
    -   Date\
    -   Time\
-   Priority is color-coded

------------------------------------------------------------------------

#### ➤ Logout

-   Destroys session\
-   Redirects back to login page

------------------------------------------------------------------------

## ✨ Features

-   Add, Edit, Delete tasks\
-   Mark tasks as Completed / Pending\
-   Priority-based task management\
-   Deadline tracking (date + time)\
-   Real-time statistics dashboard\
-   Priority filtering\
-   Session-based login system\
-   Clean and responsive UI

------------------------------------------------------------------------

## 🛠️ Tech Stack

-   **Frontend:** HTML, CSS\
-   **Backend:** PHP\
-   **Database:** MySQL (MySQLi)\
-   **Server:** XAMPP (Apache + MySQL)

------------------------------------------------------------------------

## 💡 Common Issues

**Database not working**\
→ Make sure `todo_project` is created correctly

**Tables missing**\
→ Run SQL queries properly

**Project not opening**\
→ Check Apache is running

**Login not working**\
→ Verify `users` table contains admin credentials

------------------------------------------------------------------------

## 👨‍💻 Authors

-   Rajat Kumar Singh\
-   Sarthak Srivastav
