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
- [Images](#images)
   - [Homepage](#homepage)
   - [Filtered](#filtered)
   - [Movie](#movie)
   - [Show](#show)
- [Responsiveness](#responsiveness)




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


## Images
Here are some images of the website in action!

### Homepage
The All, Movies, TV SHows all show similar views. The All shows all Media where as Movies/TV Shows show just the respsective type.

<img width="1680" alt="overview" src="https://github.com/user-attachments/assets/cfe6a2ec-5062-4cc9-9a00-7bbdbd1ca655">

### Filtered
Showcasing the view list when a filter is selected.

<img width="1678" alt="image" src="https://github.com/user-attachments/assets/ca8e0f75-0b44-4d97-96ce-c2dce24bd0f7">

### Movie
Showcasing the when selecting a Movie from the list.

<img width="1672" alt="image" src="https://github.com/user-attachments/assets/e0347571-4b35-40da-ab90-c02b66da0267">
<img width="1680" alt="image" src="https://github.com/user-attachments/assets/21dc8d8f-daa5-431e-8b3b-645430b0da35">

### Show
Showcasing the when selecting a Show from the list.

<img width="1676" alt="image" src="https://github.com/user-attachments/assets/5e159f9a-e8ce-4e25-bcb1-acab5dd8a5fb">
<img width="1674" alt="image" src="https://github.com/user-attachments/assets/ae823cd4-b703-4200-8d50-a0a807067901">

## Responsiveness
I considered making the website respond well on all devides from phones to deskstop size screens.





