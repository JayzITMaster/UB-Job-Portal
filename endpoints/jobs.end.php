<?php

include "../controller/apicontroller.php";

//gets all jobs --done
if (isset($_POST["getJobs"])) {
    $controller = new APIController();
    $response = $controller->GetJobs();
    $responseJson = json_encode($response);
    echo $responseJson;
}
//gets a job with a specific id -- done
if (isset($_POST["getJobWithId"])) {
    $controller = new APIController();
    $response = $controller->GetJobWithId($_POST["jobId"]);
    $responseJson = json_encode($response);
    echo $responseJson;
}
//updates the values of the job -- done
if (isset($_POST["updateJobWithId"])) {
    $controller = new APIController();
    $job_id = $_POST["job_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $location_id = $_POST["location_id"];
    $category_id = $_POST["category_id"];
    $job_type_id = $_POST["job_type_id"];
    $details_doc = null;
    if (isset($_FILES['details_doc']) && $_FILES['details_doc']['error'] == UPLOAD_ERR_OK) {
        // $details_doc = $_FILES['details_doc'];
        $fileTmpPath = $_FILES['details_doc']['tmp_name'];
        $fileSize = $_FILES['details_doc']['size'];
        $details_doc = file_get_contents($fileTmpPath);
        $logger = New Logger();
        $logger->info("details doc provided");
    } else {
        $logger = New Logger();
        $logger->info("details doc not provided");
    }
    $response = $controller->UpdateJobWithId($job_id, $title, $description, $location_id, $category_id, $details_doc, $job_type_id);
    $responseJson = json_encode($response);
    echo $responseJson;
}
//delete a job -- done
if (isset($_POST["deleteJobWithId"])) {
    $controller = new APIController();
    $response = $controller->DeleteJobWithId($_POST["jobId"]);
    $responseJson = json_encode($response);
    echo  $responseJson;
}
//creates a new job -- done
if (isset($_POST["createJob"])) {
    $controller = new APIController();
    $title = $_POST["title"];
    $description = $_POST["description"];
    $employerid = $_POST["employerid"];
    $location_id = $_POST["location_id"];
    $category_id = $_POST["category_id"];
    $job_type_id = $_POST["job_type_id"];
    $details_doc = null;
    if (isset($_FILES['details_doc']) && $_FILES['details_doc']['error'] == UPLOAD_ERR_OK) {
        // $details_doc = $_FILES['details_doc'];
        $fileTmpPath = $_FILES['details_doc']['tmp_name'];
        $fileSize = $_FILES['details_doc']['size'];
        $details_doc = file_get_contents($fileTmpPath);
    } else {
        $details_doc = null;
    }
    $response = $controller->createJob($employerid, $title, $description, $location_id, $category_id, $details_doc, $job_type_id);
    $responseJson = json_encode($response);
    echo $responseJson;
}

