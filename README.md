
# Fleet Managemnt System

The project is a Laravel-based application built on Laravel 10. It includes various entities like stations, routes, vehicles, seats, bookings, trips and subroutes. The application follows best practices and utilizes Laravel's features such as Eloquent ORM, migrations, seeders, API versioning, caching, and recursive algorithms to efficiently manage and manipulate data. Additionally, the project includes a dashboard for easy administration and monitoring of the application's entities and their respective data.

# Notes

- The seeder files provide the necessary dummy data for the application.
- The application includes a complete dashboard that is fully functional.
- A Postman collection is provided for testing the application's API endpoints.


## Admin Panel

   ````
   http://{URL}/admin
   
    email: admin@admin.com
    password: password
   ````

## API Collection ( Postman )

   ````
   https://documenter.getpostman.com/view/25680564/2s93sXbZtw
   ````
    
## Installation

To install and run the application, follow these steps:

1. Clone the repository to your local machine:

   ````
   git clone https://github.com/asamirsherif/fleet-management-system
   ````

2. Navigate to the project directory:

   ````
   cd laravel-10-project
   ````

3. Install the project dependencies using Composer:

   ````
   composer install
   ````

4. Copy the `.env.example` file to a new `.env` file:

   ````
   cp .env.example .env
   ````

5. Generate a new application key:

   ````
   php artisan key:generate
   ````

6. Create a new database for the application.

7. Update the `DB_*` variables in the `.env` file with your database credentials.

8. Run the database migrations:

   ````
   php artisan migrate
   ````


9. Seed the database with sample data:

   ````
   php artisan db:seed
   ````
10. Install Passport Pacakge

   ````
   php artisan passport:install
   ````

## Running the Application

To run the application, use the following command:

````
php artisan serve
````

This will start a development server at `http://localhost:8000`. You can now open your web browser and navigate to that URL to view the application.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

This project was created as part of a task on Laravel 10. Special thanks to the Laravel community for their excellent documentation and support.
