## Introduction
Zameel (زميل) - an Arabic word for "Classmate" - is a mobile app that manages student's content like schedule, books, activities, and exams in an organized way.
> [!NOTE]  
> This is a server side application project, the client side can be found in [here](https://github.com/khateeboveskey/zameel).

## Installation Steps
To set up the project locally, follow these steps:

1. **Clone the Repository**
   ```sh
   git clone <repository_url>
   cd <project_directory>
   ```

2. **Install Dependencies**
   ```sh
   composer install
   npm install
   ```

3. **Set Up Environment**
   - Copy the `.env.example` file and rename it to `.env`:
     ```sh
     cp .env.example .env
     ```
   - Update the `.env` file with your database credentials.

4. **Generate Application Key**
   ```sh
   php artisan key:generate
   ```

5. **Run Migrations and Seed Database**
   ```sh
   php artisan migrate --seed
   ```

6. **Run the Development Server**
   ```sh
   php artisan serve
   ```
   The application will be available at `http://127.0.0.1:8000`.
