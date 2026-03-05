# Water Borehole Management System (WBMS)

## Overview

The **Water Borehole Management System (WBMS)** is a web-based application designed to manage community boreholes, track maintenance issues, and coordinate repair activities between administrators, technicians, and community members.

The system allows community users to report borehole faults, administrators to assign technicians, and technicians to update maintenance progress until the issue is resolved.

This system improves **monitoring, accountability, and maintenance coordination** for community water infrastructure.



# System Objectives

The main objectives of the system are:

* To allow communities to report borehole faults quickly.
* To help administrators monitor borehole status.
* To assign technicians to maintenance tasks.
* To track maintenance progress from report to completion.
* To store borehole and maintenance records in a structured database.



# System Features

## 1. User Authentication

The system provides secure login functionality with role-based access.

Features include:

* User login system
* Password hashing
* Session management
* Role-based access control

User roles include:

* **Admin**
* **Technician**
* **Community**



# User Roles and Privileges

## Admin

The administrator manages the entire system.

Admin capabilities include:

* Add and manage boreholes
* View maintenance reports
* Assign technicians to maintenance tasks
* Manage users (add, edit, delete)
* Monitor borehole health through the dashboard



## Technician

Technicians handle maintenance operations.

Technician capabilities include:

* View assigned maintenance tasks
* Update maintenance status
* Mark tasks as completed

Status updates include:

* Pending
* In Progress
* Completed



## Community User

Community members report borehole issues.

Community capabilities include:

* Register an account
* Report borehole problems
* Track borehole maintenance status



# System Workflow

The system follows the workflow below:

1. A community user reports a borehole issue.
2. The report is stored in the database.
3. The administrator reviews the report.
4. The administrator assigns a technician to the maintenance task.
5. The technician updates the maintenance status.
6. The system reflects updates across admin and community dashboards.



# Database Design

The system uses a **MySQL relational database** consisting of the following tables:

## 1. Users Table

Stores system users.

Fields:

* id (Primary Key)
* username
* password
* role (admin, technician, community)



## 2. Boreholes Table

Stores borehole information.

Fields:

* id (Primary Key)
* borehole_name
* location
* status (working, faulty)
* created_at



## 3. Reports Table

Stores issues reported by community users.

Fields:

* id (Primary Key)
* borehole_id (Foreign Key)
* reported_by (Foreign Key)
* report_text
* date_reported



## 4. Maintenance Tasks Table

Stores maintenance assignments.

Fields:

* id (Primary Key)
* borehole_id (Foreign Key)
* reported_issue
* assigned_to (Foreign Key)
* status (Pending, In Progress, Completed)
* date_reported
* date_completed



# Database Relationships

The database uses relational integrity through foreign keys.

Relationships include:

* **Users → Reports**

  * A community user can submit many reports.

* **Boreholes → Reports**

  * Each report belongs to a specific borehole.

* **Boreholes → Maintenance Tasks**

  * Each maintenance task is linked to a borehole.

* **Users → Maintenance Tasks**

  * Technicians are assigned maintenance tasks.

This relational structure ensures accurate tracking of borehole issues and maintenance progress.



# Technologies Used

Frontend:

* HTML
* CSS
* JavaScript
* AJAX

Backend:

* PHP

Database:

* MySQL

Server Environment:

* XAMPP / Localhost

Database Access:

* PDO (PHP Data Objects)



# Security Features

The system includes several security mechanisms:

* Password hashing using `password_hash()`
* Prepared statements using PDO
* Session-based authentication
* Role-based page access control
* Input sanitization using `htmlspecialchars()`



# System Architecture

The system follows a **modular folder structure**:


DWD/
│
├── admin/
│   ├── dashboard.php
│   ├── manage_boreholes.php
│   ├── view_maintenance.php
│   ├── reports.php
│   ├── manage_users.php
│
├── technician/
│   ├── dashboard.php
│   ├── assigned_tasks.php
│
├── community/
│   ├── dashboard.php
│   ├── report_issue.php
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── sidebar.php
│
├── database.php
├── login.php
├── signup.php
├── logout.php


This structure separates system components for easier maintenance and scalability.



# Installation Guide

To run the system locally:

1. Install **XAMPP** or another PHP server environment.
2. Place the project folder inside the **htdocs** directory.
3. Start **Apache and MySQL** from XAMPP.
4. Open **phpMyAdmin**.
5. Create a database.
6. Import the provided SQL file.
7. Update database credentials in:


database.php


8. Run the system in the browser:


http://localhost/DWD/


# Future Improvements

Possible system improvements include:

* Email notifications for maintenance updates
* SMS alerts for borehole faults
* Maintenance history analytics
* Mobile responsive interface
* GIS map integration for borehole locations



# Conclusion

The Water Borehole Management System provides an efficient solution for tracking community water infrastructure and maintenance activities. The system demonstrates practical implementation of **web development, database management, and role-based system architecture**.



# Author

Doris Hozza
Student Project – Water Borehole Management System


