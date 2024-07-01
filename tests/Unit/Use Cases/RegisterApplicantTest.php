<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class RegisterApplicantTest extends TestCase
{
    public function testCanRegisterNewApplicantWithValidDetails(): void
    {
        //create the instance of the Applicant
        $newApplicant = new Applicant("", "2021154344", "John", "Doe", "john@example.com", "password123", "password123");        
        $controller = new APIController();
        $result = $controller->registerUser($newApplicant);
        $this->assertSame($result[0]->getNotifications()[0], "Applicant is registered");
        $this->assertSame($result[1], true);
    }
    public function testCannotRegisterNewApplicantWithInvalidEmail(): void
    {
        //create the instance of the Applicant
        $newApplicant = new Applicant("", "20239822", "John", "Doe", "johnexample.com", "password123", "password123");         
        $controller = new APIController();
        // Assert that an exception is thrown when trying to register the Applicant
        $this->expectException(InvalidArgumentException::class);
        $result = $controller->registerUser($newApplicant);
    }
    public function testCannotRegisterNewApplicantWithInvalidNames(): void
    {
        //create the instance of the Applicant
        $newApplicant = new Applicant("", "20239822", "John", "Doe&&", "john@example.com", "password123", "password123");         
        $controller = new APIController();
        // Assert that an exception is thrown when trying to register the Applicant
        $this->expectException(Exception::class);
        $result = $controller->registerUser($newApplicant);
    }
    public function testCannotRegisterNewApplicantWithPasswordMismatch(): void
    {
        //create the instance of the Applicant
        $newApplicant = new Applicant("", "20239822", "John", "Doe", "john@example.com", "password", "password123");         
        $controller = new APIController();
        // Assert that an exception is thrown when trying to register the Applicant
        $this->expectException(Exception::class);
        $result = $controller->registerUser($newApplicant);
    }
    public function testCannotRegisterNewApplicantWithPasswordLength(): void
    {
        //create the instance of the Applicant
        $newApplicant = new Applicant("", "20239822", "John", "Doe", "john@example.com", "pass", "pass");         
        $controller = new APIController();
        // Assert that an exception is thrown when trying to register the Applicant
        $this->expectException(Exception::class);
        $result = $controller->registerUser($newApplicant);
    }
    public function testCannotRegisterNewApplicantWithInvalidStudentId(): void
    {
        //create the instance of the Applicant
        $newApplicant = new Applicant("", "20239", "John", "Doe", "john@example.com", "password", "password123");         
        $controller = new APIController();
        // Assert that an exception is thrown when trying to register the Applicant
        $this->expectException(Exception::class);
        $result = $controller->registerUser($newApplicant);
    }
}
