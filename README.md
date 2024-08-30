
# Car Management System

## Overview
This project implements a simple Car Management System using Django for the API backend and PHP for the frontend interface. It allows users to perform CRUD (Create, Read, Update, Delete) operations on car records.

## Features
- **Create Car**: Add new cars with details such as name, version, and model.
- **Read Car**: View a list of all cars currently in the system.
- **Update Car**: Modify existing car details.
- **Delete Car**: Remove cars from the system.

## Technologies Used
- **Backend (Django API)**:
  - Django (Python web framework)
  - Django REST Framework (for building RESTful APIs)
  - PostgreSQL (Database for storing car records)

- **Frontend (PHP)**:
  - HTML, CSS (Bootstrap for styling)
  - JavaScript (jQuery for AJAX requests)
  
## Setup Instructions

### Backend (Django API)
1. Clone the repository:
   ```bash
   git clone <repository_url>
   cd <repository_name>
   ```

2. Install Python dependencies using `pip`:
   ```bash
   pip install -r requirements.txt
   ```

3. Apply database migrations:
   ```bash
   python manage.py migrate
   ```

4. Run the Django development server:
   ```bash
   python manage.py runserver
   ```
   The API will be accessible at `http://localhost:8000/api/cars/`.

### Frontend (PHP)
1. Place the PHP files (`index.php`, `edit.php`, `update.php`, `delete.php`) in your web server's root directory (e.g., `htdocs` for XAMPP).

2. Ensure PHP is installed on your system. If not, install it using:
   ```bash
   sudo apt install php-cli
   ```

3. Start the PHP built-in server:
   ```bash
   php -S localhost:8080
   ```
   The frontend will be accessible at `http://localhost:8080`.

## Usage
- **Creating a Car**: Fill out the form fields (`Car Name`, `Car Version`, `Car Model`) and click `Create Car`.
- **Updating a Car**: Click `Update` next to the car you wish to modify, make changes in the form, and click `Update Car`.
- **Deleting a Car**: Click `Delete` next to the car you want to remove from the system.

## Troubleshooting
- **Database Connection**: Ensure PostgreSQL is properly installed and configured in your Django project settings (`settings.py`).
- **PHP Installation**: If PHP is not recognized, install it using the appropriate package manager (`apt`, `yum`, `brew`).

## Contributing
Feel free to fork the repository, create pull requests, or open issues for bugs or feature requests.

