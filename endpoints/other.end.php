<?php


include "../controller/apicontroller.php";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $controller = new APIController();
    $response = $controller->login($email, $password);
    $responseJson = json_encode($response);
    echo $responseJson;
}
