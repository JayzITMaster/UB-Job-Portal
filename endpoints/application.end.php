<?php
include "../controller/apicontroller.php";


//returns an application with a specific id --done
if (isset($_POST["getApplicationWithId"])) {
    $controller = new APIController();
    $response = $controller->GetApplicationWithId($_POST["application_id"]);
    $responseJson = json_encode($response);
    echo $responseJson;
}
//returns all applications created by an applicant --done
//for applicants to see the list of their applications
if (isset($_POST["getApplicationsWithApplicantId"])) {
    $controller = new APIController();
    $response = $controller->GetApplicationsWithApplicantId($_POST["applicant_id"]);
    $responseJson = json_encode($response);
    echo $responseJson;
}
//returns all applications for a job to an employer  --done
//for an employer to see indiduals that applied for a job
if (isset($_POST["getApplicationsWithJobId"])) {
    $controller = new APIController();
    $response = $controller->GetApplicationsWithJobId($_POST["jobId"]);
    $responseJson = json_encode($response);
    echo $responseJson;
}
//creates an application for a job and associated applicant -- done
if (isset($_POST["createApplication"])) {
    $controller = New APIController();
    $response = $controller->createApplication($_POST["jobId"], $_POST["applicant_id"]);
    $responseJson = json_encode($response);
    echo $responseJson;
}
