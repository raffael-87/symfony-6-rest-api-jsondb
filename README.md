# API Documentation
## - A REST API written for training purposes with PHP 8.2 and Symfony 6.2 
## - The data is stored in root/data/books.json
<br>

## Base URL
http://localhost:8000/books

## Endpoints
- **GET /books** - Get a list of all books
- **GET /books/{id}** - Get a single book by ID
- **POST /books** - Create a new book
- **PUT /books/{id}** - Update a book by ID
- **DELETE /books/{id}** - Delete a book by ID

## Setup
- open your terminal
- clone the repo
- cd in it
- to start the API, enter: `symfony serve -d`