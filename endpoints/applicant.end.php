<?php
include "../controller/apicontroller.php";

//returns all applicants --done
if (isset($_POST["getApplicants"])) {
    $controller = new APIController();
    $response = $controller->GetApplicants();
    $responseJson = json_encode($response);
    echo $responseJson;
}
// //returns applicant with a specific id -- done
if (isset($_POST["getApplicantWithId"])) {
    $controller = new APIController();
    $response = $controller->GetApplicantWithId($_POST["applicant_id"]);
    $responseJson = json_encode($response);
    echo $responseJson;
}
// //updates the values of the applicant --done
if (isset($_POST["updateApplicantWithId"])) {
    $id = $_POST["applicant_id"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $description = $_POST["description"];
    $studentId = $_POST["studentId"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phone_number"];
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        // $profile_picture = $_FILES['profile_picture'];
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $profile_picture = file_get_contents($fileTmpPath);
    } else {
        $profile_picture = null;
    }
    $resume = null;
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        // $resume = $_FILES['resume'];
        $fileTmpPath = $_FILES['resume']['tmp_name'];
        $fileSize = $_FILES['resume']['size'];
        $resume = file_get_contents($fileTmpPath);
    } else {
        $resume = null;
    }
    $controller = new APIController();  
    $response = $controller->UpdateApplicantWithId($id, $firstname, $lastname, $profile_picture, $description, $studentId, $email, $phoneNumber, $resume);
    $responseJson = json_encode($response);
    echo $responseJson;
}
//deletes the applicant --done
if (isset($_POST["deleteApplicant"])) {
    $controller = new APIController();
    $response = $controller->DeleteApplicantWithId($_POST["applicant_id"]);
    $responseJson = json_encode($response);
    echo $responseJson;
}
//registers a new applicant -- done
if (isset($_POST["createApplicant"])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $studentId = $_POST["studentId"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeatedPassword = $_POST["rpt_pwd"];
    $phoneNumber = $_POST["phone_number"];
    $controller = new APIController();
    $response = $controller->createApplicant($firstname, $lastname, $studentId, $email, $password, $repeatedPassword, $phoneNumber);
    $responseJson = json_encode($response);
    echo $responseJson;
}
