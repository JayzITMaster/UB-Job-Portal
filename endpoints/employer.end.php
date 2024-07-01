<?php
include "../controller/apicontroller.php";

//returns all employers --done
if (isset($_POST["getEmployers"])) {
    $controller = new APIController();
    $response = $controller->GetEmployers();
    $responseJson = json_encode($response);
    echo $responseJson;
}
//returns employer with a specific id -- done
if (isset($_POST["getEmployerWithId"])) {
    $controller = new APIController();
    $response = $controller->GetEmployerWithId($_POST["employer_id"]);
    $responseJson = json_encode($response);
    echo $responseJson;
}
//updates the values of the employer --done
if (isset($_POST["updateEmployerWithId"])) {
    $id = $_POST["employer_id"];
    $companyName = $_POST["company_name"];
    $recruiterFirstname = $_POST["recruiter_firstname"];
    $recruiterLastname = $_POST["recruiter_lastname"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phone_number"];
    $logger =  New Logger;
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        // $profile_picture = $_FILES['profile_picture'];
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $profile_picture = file_get_contents($fileTmpPath);
        $logger->info("reached this");
    } else {
        $logger->info("reached");
        $profile_picture = null;
    }
    $controller = new APIController();
    $response = $controller->UpdateEmployerWithId($id, $companyName, $recruiterFirstname, $recruiterLastname, $email, $phoneNumber, $profile_picture);
    $responseJson = json_encode($response);
    echo $responseJson;
}
//deletes the employer --done
if (isset($_POST["deleteEmployerWithId"])) {
    $controller = new APIController();
    $response = $controller->DeleteEmployerWithId($_POST["employer_id"]);
    $responseJson = json_encode($response);
    echo $responseJson;
}
//registers a new employer -- done
if (isset($_POST["createEmployer"])) {
    $companyName = $_POST["company_name"];
    $recruiterFirstname = $_POST["recruiter_firstname"];
    $recruiterLastname = $_POST["recruiter_lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeatedPassword = $_POST["rpt_pwd"];
    $phoneNumber = $_POST["phone_number"];
    $controller = new APIController();
    $response = $controller->createEmployer($companyName, $recruiterFirstname, $recruiterLastname, $email, $password, $repeatedPassword, $phoneNumber);
    $responseJson = json_encode($response);
    echo $responseJson;
}
