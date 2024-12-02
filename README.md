# Task Management System

This is a simple task management system built using Laravel.

## Installation

To install the Task Management System, you can follow the steps below:

### Local Installation

First, clone the repository to your local machine using the following command:

```
git clone https://github.com/graspstudios/task-management-system.git
```

Then Run this command to start the application.

```
php artisan start:app
```

Then go to

```
 http://127.0.0.1:8000
```

Login Credentials

```
email: admin@graspstudios.fho
password: password
```

### Docker Installation

#### Using Laravel Sail To Start The Application using Docker

To use Laravel Sail, you must have Docker installed on your machine.

First, build the Docker containers with the following command:

```
./vendor/bin/sail up -d
```

This will start the Docker containers for the application.

Then start the application with the following command:

```
php artisan start:app
```

Serve the application with the following command:

```
./vendor/bin/sail serve
```
Then go to

```
 http://127.0.0.1:8000
```

To stop the Docker containers, use the following command:

```
./vendor/bin/sail down
```
