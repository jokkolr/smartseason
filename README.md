# 🌾 SmartSeason Field Monitoring System

SmartSeason is a full-stack agricultural field monitoring system that allows admins to manage fields, assign agents, and track crop growth stages in real time. It uses a PHP backend, MySQL database, and a JavaScript frontend dashboard.

## System Architecture
Frontend (HTML/CSS/JS) → Fetch API (JavaScript) → PHP Backend → MySQL Database

## Features
- Admin & Agent role-based access
- Create and manage fields
- Assign fields to agents
- Update crop growth stages
- View dashboard analytics
- Real-time updates
- Chart visualization using Chart.js

## Tech Stack
Frontend: HTML, CSS, JavaScript, Chart.js  
Backend: PHP  
Database: MySQL  

## Database Schema
CREATE TABLE fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    crop VARCHAR(100),
    planting_date DATE,
    stage VARCHAR(50),
    assigned_to VARCHAR(100)
);

## API Endpoints

Add Field (POST /add_field.php)
Request:
{
  "name": "Field A",
  "crop": "Maize",
  "date": "2026-04-20",
  "stage": "Planted",
  "assigned_to": "agent@email.com"
}

Get Fields (GET /get_fields.php?email=&role=)
Response:
[
  {
    "id": 1,
    "name": "Field A",
    "crop": "Maize",
    "stage": "Growing",
    "assigned_to": "agent@email.com"
  }
]

Update Field (POST /update_field.php)
{
  "id": 1,
  "stage": "Harvested"
}

## Frontend Logic Example
function addField() {
  const field = {
    name: document.getElementById("fieldName").value,
    crop: document.getElementById("cropType").value,
    date: document.getElementById("plantingDate").value,
    stage: document.getElementById("stage").value,
    assigned_to: document.getElementById("agentSelect").value
  };

  fetch("add_field.php", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify(field)
  })
  .then(res => res.json())
  .then(data => console.log(data));
}

## Dashboard
- Total fields counter
- Planted / Growing / Harvested tracking
- Chart.js visual analytics

## Design Decisions
- PHP REST-style API
- JSON-based communication
- Role-based access control in backend
- Prepared statements for database security
- Lightweight frontend (no frameworks)

## Assumptions
- Users are pre-registered
- Admin assigns agents manually
- System runs on shared hosting (InfinityFree)

## Live Demo
https://smartseason.infinityfreeapp.com/
## Author
SmartSeason Technical Assessment Project – Software Engineer Intern Application
