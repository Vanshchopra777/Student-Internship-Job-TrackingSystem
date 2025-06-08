create database if not exists dbms_project;
use dbms_project;

-- students table
create table student (
    student_id int primary key auto_increment,
    name varchar(100),
    email varchar(100) unique,
    branch varchar(60),
    cgpa decimal(3,2),
    resume_link varchar(255),
    phone_number varchar(15)
);

-- companies
create table company (
    company_id int auto_increment primary key,
    name varchar(150),
    industry_type varchar(90),
    hr_name varchar(100),
    hr_email varchar(100)
);

-- job/internship details
create table job_internship (
    job_id int auto_increment primary key,
    company_id int,
    title varchar(160),
    job_type enum('Job', 'Internship'),
    description text,
    stipend_ctc varchar(60),
    deadline date,
    location varchar(100),
    eligibility text,
    foreign key (company_id) references company(company_id)
);

-- apps by students
create table application (
    application_id int auto_increment primary key,
    student_id int,
    job_id int,
    date_applied date,
    status enum('Applied','Shortlisted','Interview Scheduled','Selected','Rejected') default 'Applied',
    foreign key (student_id) references student(student_id),
    foreign key (job_id) references job_internship(job_id)
);

-- interviews (not always scheduled)
create table interview (
    interview_id int auto_increment primary key,
    application_id int,
    interview_date date,
    mode enum('Online','Offline'),
    result enum('Pending','Selected','Rejected') default 'Pending',
    foreign key (application_id) references application(application_id)
);

-- placement cell officers
create table placement_officer (
    officer_id int auto_increment primary key,
    name varchar(100),
    email varchar(100),
    department varchar(80),
    phone_number varchar(15)
);

-- insert students
insert into student (name, email, branch, cgpa, resume_link, phone_number) values
('Aarav Mehta', 'aarav.m@dtu.ac.in', 'Comp Engg', 9.11, 'https://resume-link-aarav', '9876543210'),
('Riya Sharma', 'riya.sh@dtu.ac.in', 'IT', 8.7, 'https://resume-link-riya', '9811223344'),
('Kunal Verma', 'kunal.v@dtu.ac.in', 'Soft Engg', 8.45, 'https://resume-link-kunal', '9898989898'),
('Simran K', 'simran.k@dtu.ac.in', 'ECE', 9.2, 'https://drive.com/resume-simran', '9123456780'),
('Dev Joshi', 'dev.j@dtu.ac.in', 'Mech', 8.59, 'https://link.com/dev-resume', '9012345678');

-- insert companies
insert into company (name, industry_type, hr_name, hr_email) values
('Google India', 'Tech', 'Ananya G.', 'ananya@google.com'),
('Goldman', 'Finance', 'Rohit A.', 'rohit.gs@gs.com'),
('Zomato Ltd', 'FoodTech', 'Priya Singh', 'priya.s@zomato.com');

-- insert job/interns
insert into job_internship (company_id, title, job_type, description, stipend_ctc, deadline, location, eligibility) values
(1, 'SWE Intern - Summer 2025', 'Internship', 'Work on live G-apps', '80k INR/month', '2025-07-01', 'Bangalore', '9+ CGPA, coding skills'),
(2, 'Analyst Role', 'Job', 'Banking work, deals', '₹20,00,000', '2025-06-15', 'Mumbai', '8.5+ CGPA, Excel ok'),
(3, 'Product Internship', 'Internship', 'Assist with new features', '30k pm', '2025-06-20', 'Ggn', 'All branches ok');

-- applications
insert into application (student_id, job_id, date_applied, status) values
(1, 1, '2025-05-20', 'Applied'),
(2, 2, '2025-05-22', 'Shortlisted'),
(3, 3, '2025-05-24', 'Interview Scheduled');

-- interviews
insert into interview (application_id, interview_date, mode, result) values
(1, '2025-06-05', 'Online', 'Pending'),
(2, '2025-06-10', 'Offline', 'Selected'),
(3, '2025-06-08', 'Online', 'Pending');

-- placement team
insert into placement_officer (name, email, department, phone_number) values
('Neha Bansal', 'neha.b@dtu.ac.in', 'CSE Dept', '9123456789'),
('Rajat Malhotra', 'rajat.m@dtu.ac.in', 'IT Dept', '9876543211');
