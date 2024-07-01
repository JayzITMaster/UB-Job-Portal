<?php

include "../controller/apicontroller.php";

if (isset($_POST["registerAccount"])) { //if a button to add a new user is clicked
    $result = "";
    if (isset($_POST["username"])) { //if a username was passed, the employer wants to sign up
        //create the instance of the employer
        $newEmployer = new Employer(0, $_POST["firstname"], $_POST["lastname"], $_POST["password"], $_POST["repeatedPassword"], $_POST["companyEmail"], $_POST["companyName"], $_POST["phoneNumber"]);
        $controller = new APIController();
        $result = $controller->registerUser($newEmployer);
    } else if (isset($_POST["firstname"])) {
        $newApplicant = new Applicant("", $_POST["studentid"], $_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"], $_POST["repeatedpassword"]);
        $controller = new APIController();
        $result = $controller->registerUser($newApplicant);
    }
    session_start();
    if ($result[1] == true) {   
        $_SESSION["SuccessfulRegistrationNotification"] = $result[0]->getNotifications()[0];
        $_SESSION["NotificationDescription"] = $result[0]->getNotifications()[1];
        header("Location: ../views/login.php?registersuccess");
        exit();
    } else {
        $_SESSION["ErrorNotification"] = $result[0]->getNotifications()[0];
        $_SESSION["NotificationDescription"] = $result[0]->getNotifications()[1];
        header("Location: ../views/register.php?error=internalerror");
        exit();
    }
    return;
} else if (isset($_POST["applyForJob"])) {
    $controller = new APIController();
    $result = $contoller->applyForJob($_POST["postid"]);
    session_start();
    if ($result[1] == true) {
        $_SESSION["SuccessfulApplication"] = $result[0]->getNotifications()[0];
        $_SESSION["NotificationDescription"] = $result[0]->getNotifications()[1];
        header("Location: ../views/joblist.php?application=success"); //stay on the same screen
        exit();
    } else {
        $_SESSION["ErrorNotification"] = $result[0]->getNotifications()[0];
        $_SESSION["NotificationDescription"] = $result[0]->getNotifications()[1];
        header("Location: ../views/joblist.php?error=internalerrror"); //stay on the same screen
        exit();
    }
    return;
}







//register an account


//login


//return profile information

//apply for a job

// 