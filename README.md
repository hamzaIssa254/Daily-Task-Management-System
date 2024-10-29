# Daily Task Management System

A simple Laravel-based daily task management system that allows users to create, edit, delete, and manage tasks via a Blade-based interface. The system includes an automated Cron Job to send daily emails to users with pending tasks.

## Features
- **User Authentication**: Users can register and log in to access their task management dashboard.
- **Task Management**: Users can add, edit, delete, and mark tasks as 'Pending' or 'Completed'.
- **Daily Email Reminders**: Using Laravel's command scheduler, the system sends a daily email with pending tasks.
- **Error Handling**: Handles errors gracefully with user-friendly messages.
- **Caching**: Improves performance by caching frequently accessed data.
- **Data Filtering**: Filter tasks based on status (Pending, Completed).

## Requirements
- PHP 8.x
- Composer
- Laravel 10.x
- Database (MySQL, PostgreSQL, etc.)
- Mailtrap (for email testing)

## Installation

1. **Clone the repository**:
   ```bash
   git clone [https://github.com/username/daily-task-management-system.git](https://github.com/hamzaIssa254/Daily-Task-Management-System.git
   cd daily-task-management-system
## Install dependencies:
- **composer install**

## Environment setup:
-**cp .env.example .env**

## Generate the application key:
-**php artisan key:generate**

## Run migrations:
-**php artisan migrate**

## Mailtrap configuration:
-**Sign up for a Mailtrap account at Mailtrap.io.**
--**Copy your Mailtrap SMTP settings to .env:**
**MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=example@example.com
MAIL_FROM_NAME="Daily Task Management System"**

## Start the development server:
**php artisan ser**

## Usage:
1-Register a user through the /register route.
2-Login and navigate to the dashboard.
3-Manage tasks:
**View a list of tasks on the tasks.index page**.
**Create a new task through the tasks.create page**.
**Edit or delete tasks directly from the task list**.
**Change task status between Pending and Completed**.

## Command & Scheduled Job Setup:
-The system includes a scheduled job to send daily emails containing pending tasks.

## Run the command manually:
**php artisan app:send-daily-tasks-email**

## Schedule the command: To set up the job to run automatically every day, add the following Cron job to your server’s crontab:
**php artisan schedule:work**
**Laravel’s scheduler will ensure app:send-daily-tasks-email runs as per the schedule defined in App\Console\Kernel.php.**

## Code Structure:
**Controller: Manages requests and passes data to Blade views.**
**Service Layer: Business logic for task management is abstracted into a service for cleaner controller code.**
**Blade Views: Handles front-end task management (task listing, creation, editing).**
**Jobs: SendDailyTasksEmailJob sends emails daily.**
**Mail: DailyTasksEmail mailable handles email formatting.**

## Caching and Performance:
**Frequently accessed tasks are cached using Laravel’s cache system to optimize performance. For example:**
**Cache::remember('tasks', 3600, function () {
    return Task::all();
});**

## Blade Directives:
**@if: Conditionally displays elements, like task status labels.**
**@foreach: Loops through tasks for easy listing.**
**@csrf: Protects forms against CSRF attacks.**

## Testing:
**Test emails can be viewed directly in Mailtrap’s inbox.**

## License:
**This project is open-source and available under the MIT License.**
