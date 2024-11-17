# netwatch-technical-test
A simple application using Laravel that provides a list of TV shows and movies.

# Table of Contents
- [Objective](#objective)
- [Requirements](#requirements)
  - [Models/Database](#modelsdatabase)
  - [Data Generation](#data-generation)
  - [Frontend](#frontend)
  - [Testing](#testing)
- [Techstack](#techstack)
  - [Frontend](#frontend)
  - [Backend](#backend)
  - [Database](#database)
  - [Testing](#testing)
- [Seeding](#seeding)
   - [Movies/Shows/Users](#moviesshowsusers)
   - [Comments](#comments)

# Objective
The goal of this challenge is to give you a chance to showcase your coding style and how you structure your work. Don't worry about making it perfect or fully polished—it's more about getting a feel for how you solve problems and build out features.

Create a simple application using **Laravel** that provides a list of TV shows and movies. The application should have a simplistic but modern front-end template built with **Vue.js**, featuring separate pages for TV shows and movies.

---

## Requirements

### Models/Database
- Store **TV shows**, **movies**, and **comments** in an **SQLite** database.
- Each TV show and movie should have attached **user comments**.

### Data Generation
- Generate sample data for TV shows, movies, and comments.

### Frontend
- Build a simple but clean and modern page template using **Vue.js** and **TailwindCSS**.
- Create **separate pages** for TV shows and movies.
- Use **TypeScript** types for all models used.
- Display the **5 latest comments** alongside each TV show and movie.

### Testing
- Include **PHPUnit** or **Pest** tests for both the TV shows and movies pages.


## Techstack

### Frontend
- Nuxtjs (uses Vue 3).
- Shadcn UI
- TailwindCSS

### Backend
- Laravel

### Database
- SQLite
- Entity Relationship Diagram:
   
![ERD Diagram](https://github.com/user-attachments/assets/b7fb27e9-411d-4802-aad7-1e144b524af7)


### Testing
- **Pest** tests for both the TV shows and movies pages.

## Seeding
I used online Dummy JSON websites to fetch and insert data in the database

### Movies/Shows/Users
I used this website -> https://jsonfakery.com

### Comments
I used this website -> [https://jsonfakery.com](https://dummyjson.com/docs/comments)
