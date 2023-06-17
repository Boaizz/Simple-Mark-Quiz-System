# Simple-Mark-Quiz-System
This is a simple quiz marking system built using PHP and MariaDB, where players can answer a quiz and supervisors can view and edit the scores. The system allows supervisors to sort scores based on their preferences.
## Setup 
Open the `setting.php` file located in the root directory of the project and update the database connection details:
```
$host = "";
$user = "";
$pwd ="";
$sql_db = "";
```
## Features
For Players
Answering the Quiz: Players can access the quiz and answer the questions provided. The system will automatically grade their responses.
## For Supervisors
View Scores: Supervisors can view the scores of all players who have taken the quiz. Scores are stored in the database.
Edit Scores: Supervisors can edit the scores of players if necessary. This feature is useful if manual grading is required.
Sort Scores: Supervisors can sort scores based on their preferences, such as highest to lowest score, alphabetical order, or any other custom criteria.