# netwatch-technical-test
A simple application using Laravel that provides a list of TV shows and movies.

# Table of Contents
- [Objective](#objective)
- [Requirements](#requirements)
  - [Models/Database](#modelsdatabase)
  - [Data Generation](#data-generation)
  - [Frontend](#frontend)
  - [Testing](#testing)
- [Assumptions](#assumptions)
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
- [Testing](#testing)




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

## Assumptions
Ideally, this application would include a login page with proper authentication. To achieve this, I would use Laravel Socialite, which enables users to log in using OAuth providers such as Facebook or Google. The backend would require two routes: one to redirect the user to the OAuth provider for authentication, and another to handle the callback, receiving the user’s information upon successful login.

Another assumption I made is that users should not have the ability to create, delete, or update movies and TV shows. But users can browse a catalog of media items where they can view, comment on, and like other users' comments. However, I chose not to implement the functionality for users to add or like comments, as this falls outside the scope of this technical test.


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
- **PHPUnit** tests was used for both the TV shows and movies pages.

## Seeding
I used online Dummy JSON websites to fetch and insert data in the database

### Movies/Shows/Users
I used this website -> https://jsonfakery.com

### Comments
I used this website -> https://dummyjson.com/docs/comments


## Images
Here are some images of the website in action!

### Homepage
The All, Movies, TV SHows all show similar views. The All shows all Media where as Movies/TV Shows show just the respsective type.

<img width="1680" alt="image" src="https://github.com/user-attachments/assets/8092cf9f-2be9-4703-8402-1eadfd9884bb">


### Filtered
Showcasing the view list when a filter is selected.

<img width="1680" alt="image" src="https://github.com/user-attachments/assets/461ccde8-5a17-4d64-9e61-34783d19709e">


### Movie
Showcasing the when selecting a Movie from the list.

<img width="1625" alt="image" src="https://github.com/user-attachments/assets/df88a525-9827-4025-a911-07f28fcbeb23">
<img width="1679" alt="image" src="https://github.com/user-attachments/assets/69696d7e-2c88-4f41-8f40-703a2c34d516">


### Show
Showcasing the when selecting a Show from the list.

<img width="1680" alt="image" src="https://github.com/user-attachments/assets/b8f4b4c8-7e93-42d9-8346-7725c577f816">
<img width="1679" alt="image" src="https://github.com/user-attachments/assets/013da681-f20e-4a0e-81fd-a194d438ee9d">


## Responsiveness
I considered making the website respond well on all devides from phones to deskstop size screens.

## Testing
I made some tests to test the CRUD applications of the Media (Movies/TV Shows) entity

<img width="383" alt="image" src="https://github.com/user-attachments/assets/01b1945d-ef3c-4a08-b5a2-50346f8e28b1">






