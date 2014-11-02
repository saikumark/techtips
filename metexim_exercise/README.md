Requirement:
-----------
We are an education institution. Students enroll for various courses. Each course has a defined syllabus and chapters. Professors teach the students as per the syllabus of the course.

We need to have web application which would list the different courses and its details. The professor would be able to login and create / manage the syllabus and chapters. And the students would be able to only view the syllabus and chapters of the course

Relationship:
------------
Professor (1) -> Student (n)

Student (1) -> Course (n)

Course (1) -> Syllabus (n) 

Syllabus (1) -> Chapters (n)

Tech Stack:
----------
HTML5, CSS3, Angular JS, jQury, PHP, MySQL

DB Schema:
----------
course: id int(11), name varchar(100)

syllabus: id int(11), course_id int(11), name varchar(100), chapters text

student: id int(11), professor_id int(11), name varchar(100), course_id int(11)

professor: id int(11), name varchar(100)
