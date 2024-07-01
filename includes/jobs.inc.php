<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
$requestData = json_decode(file_get_contents('php://input'), true);

//gets all the jobs
if (isset($requestData["jobPosts"]) && !empty($requestData["jobPosts"])) {
    $jobPostings = [
        [
            "id" => 1,
            "title" => "Software Developer",
            "company" => "Tech Solutions Ltd.",
            "location" => "Orange Walk",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Information Technology"
        ],
        [
            "id" => 2,
            "title" => "Database Administrator",
            "company" => "Data Management Inc.",
            "location" => "Corozal",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Database"
        ],
        [
            "id" => 3,
            "title" => "Web Developer",
            "company" => "WebWorks",
            "location" => "Belize",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Web Development"
        ],
        [
            "id" => 4,
            "title" => "Software Engineer",
            "company" => "Innovative Solutions",
            "location" => "Cayo",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Engineering"
        ],
        [
            "id" => 5,
            "title" => "Network Administrator",
            "company" => "NetPros",
            "location" => "Stann Creek",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Information Technology"
        ],
        [
            "id" => 6,
            "title" => "Full Stack Developer",
            "company" => "Digital Ventures",
            "location" => "Toledo",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Web Development"
        ],
        [
            "id" => 7,
            "title" => "Software Architect",
            "company" => "Architects Inc.",
            "location" => "Orange Walk",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Engineering"
        ],
        [
            "id" => 8,
            "title" => "IT Support Specialist",
            "company" => "Support Pros",
            "location" => "Corozal",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Information Technology"
        ],
        [
            "id" => 9,
            "title" => "Database Analyst",
            "company" => "Data Solutions",
            "location" => "Belize",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Database"
        ],
        [
            "id" => 10,
            "title" => "Frontend Developer",
            "company" => "Frontend Designs",
            "location" => "Cayo",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Web Development"
        ],
        [
            "id" => 11,
            "title" => "System Administrator",
            "company" => "SysAdmins Inc.",
            "location" => "Stann Creek",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Information Technology"
        ],
        [
            "id" => 12,
            "title" => "DevOps Engineer",
            "company" => "DevOps Solutions",
            "location" => "Toledo",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Engineering"
        ],
        [
            "id" => 13,
            "title" => "Software Tester",
            "company" => "Testers Ltd.",
            "location" => "Orange Walk",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Information Technology"
        ],
        [
            "id" => 14,
            "title" => "Database Developer",
            "company" => "DB Developers",
            "location" => "Corozal",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Database"
        ],
        [
            "id" => 15,
            "title" => "Backend Developer",
            "company" => "Backend Solutions",
            "location" => "Belize",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Web Development"
        ],
        [
            "id" => 16,
            "title" => "Electrical Engineer",
            "company" => "Electrical Innovations",
            "location" => "Cayo",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Engineering"
        ],
        [
            "id" => 17,
            "title" => "Software Support Specialist",
            "company" => "Software Pros",
            "location" => "Stann Creek",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Information Technology"
        ],
        [
            "id" => 18,
            "title" => "UI/UX Designer",
            "company" => "Designers Inc.",
            "location" => "Toledo",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Web Development"
        ],
        [
            "id" => 19,
            "title" => "Network Engineer",
            "company" => "Network Solutions",
            "location" => "Orange Walk",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Engineering"
        ],
        [
            "id" => 20,
            "title" => "IT Manager",
            "company" => "IT Solutions",
            "location" => "Corozal",
            "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
            "category" => "Information Technology"
        ],
    ];




    // Convert job postings array to JSON
    $jobPostingsJson = json_encode($jobPostings);

    // Set content type header
    header('Content-Type: application/json');

    // Output JSON
    echo $jobPostingsJson;
}


