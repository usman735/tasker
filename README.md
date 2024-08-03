# Task Manager

A simple task management web application built with Laravel.

## Setup

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/task-manager.git
    cd task-manager
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    npm run dev
    ```

3. Configure the `.env` file with your database credentials.

4. Run the migrations:
    ```bash
    php artisan migrate
    ```

5. Start the development server:
    ```bash
    php artisan serve
    ```

## Features

- Create, edit, and delete tasks
- Reorder tasks with drag-and-drop functionality
- Associate tasks with projects
- Filter tasks by project

## License

[MIT](LICENSE)
