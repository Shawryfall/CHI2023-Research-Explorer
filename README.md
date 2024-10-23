# CHI2023-Research-Explorer 🔍

Developed a web application to display research presented at the ACM CHI 2023 conference. Built a web API using object-oriented PHP to retrieve research data from a database in JSON format and implemented user authentication and note-taking functionality. The front end was developed using React and Tailwind CSS to provide a user-friendly interface for viewing research content and managing notes.

[![Live Demo](https://img.shields.io/badge/Live-Demo-blue)](https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/)

## 🚀 Features

### 👨‍💻 Backend API Endpoints

1. **Developer** (`/api/developer`)
   - Endpoint: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/developer](https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/developer)
   - Parameters: None

2. **Country** (`/api/country`)
   - Endpoint: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/country](https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/country)
   - Parameters: None

3. **Preview** (`/api/preview`)
   - Endpoint: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/preview](https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/preview)
   - Parameters: `limit` (e.g., `preview?limit=1`) – Only accepts number values

4. **Author and Affiliation** (`/api/author-and-affiliation`)
   - Endpoint: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/author-and-affiliation](https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/author-and-affiliation)
   - Parameters:
     - `content` (e.g., `author-and-affiliation?content=99140`)
     - `country` (e.g., `author-and-affiliation?country=japan`)

5. **Content** (`/api/content`)
   - Endpoint: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/content](https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/content)
   - Parameters:
     - `page` (e.g., `content?page=2`)
     - `type` (e.g., `content?type=paper`)

6. **Token** (`/api/token`)
   - Endpoint: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/token](https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/token)
   - Parameters: Authorization headers for username and password

7. **Note** (`/api/note`)
   - Endpoint: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/note](https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/note)
   - Parameters: `content_id` (e.g., `note?content_id=95692`)

8. **Favourites** (`/api/favourites`)
   - Endpoint: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/favourites](https://w20012045.nuwebspace.co.uk/kf6012/coursework/api/favourites)
   - Parameters: None

### 💻 Frontend Features

#### 📱 Core Pages

1. **Landing Page** 
   - URL: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/](https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/)
   - Random content preview updates every 10 seconds
   - Displays titles and preview video links

2. **Countries Page**
   - URL: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/countries](https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/countries)
   - Complete list of relevant countries
   - Search functionality with "no results found" feedback

3. **Content Page**
   - URL: [https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/content](https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/content)
   - Paginated display (20 items per page)
   - Expandable content details and author information
   - Content filtering by type
   - Displays titles, abstracts, types, awards, and links
   - Preview video links when available

#### 🔐 User Features

1. **Sign-in Functionality**
   - Sign in available on all pages
   - Visual feedback for incorrect credentials
   - 30-minute token expiration
   - Automatic logout

2. **Notes System**
   - Create and save notes for specific content
   - 255 character limit
   - POST/DELETE functionality
   - User-specific note storage

3. **Favourites System**
   - Add/remove favorites individually
   - User-specific favorites list
   - POST/DELETE functionality

#### 🎯 Additional Features

- **Navigation**
  - Menu component with route handler
  - Custom 404 page with image
  - [Example 404 page](https://w20012045.nuwebspace.co.uk/kf6012/coursework/app/sashjhswhsjw)

- **Toast Notifications**
  - Authentication status
  - Note operations feedback
  - Favorite operations feedback
  - Session status updates
  - Character limit warnings

## 🛠️ Technical Stack

- **Backend**
  - Object-oriented PHP
  - JSON API
  - MySQL Database

- **Frontend**
  - React
  - Tailwind CSS
  - React Router

## 🔗 Connect

[![LinkedIn](https://img.shields.io/badge/LinkedIn-Profile-blue)](https://www.linkedin.com/in/patrick-shaw-b57700278/)

