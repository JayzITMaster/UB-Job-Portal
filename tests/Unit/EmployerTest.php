<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class EmployerTest extends TestCase
{
    public function testConstructor()
    {
        $id = '123';
        $firstname = 'John';
        $lastname = 'Doe';
        $password = 'password';
        $repeatedPassword = 'password';
        $companyEmail = 'employer@example.com';
        $companyName = 'Example Company';
        $phoneNumber = '123456789';

        $employer = new Employer($id, $firstname, $lastname, $password, $repeatedPassword, $companyEmail, $companyName, $phoneNumber);

        $this->assertInstanceOf(Employer::class, $employer); // Check if the object is an instance of the Employer class
        $this->assertEquals($id, $employer->getEmployerId()); // Check if employerid attribute is set correctly
        $this->assertEquals($firstname, $employer->getFirstname()); // Check if firstname attribute is set correctly
        $this->assertEquals($lastname, $employer->getLastname()); // Check if lastname attribute is set correctly
        $this->assertEquals($password, $employer->getPassword()); // Check if password attribute is set correctly
        $this->assertEquals($repeatedPassword, $employer->getRepeatedPassword()); // Check if repeatedPassword attribute is set correctly
        $this->assertEquals($companyEmail, $employer->getCompanyEmail()); // Check if companyEmail attribute is set correctly
        $this->assertEquals($companyName, $employer->getCompanyName()); // Check if companyName attribute is set correctly
        $this->assertEquals($phoneNumber, $employer->getPhoneNumber()); // Check if phoneNumber attribute is set correctly
    }
}

class Employer {
    private string $employerid;
    private string $firstname;
    private string $lastname;
    private string $password;
    private string $repeatedPassword;
    private string $companyEmail;
    private string $companyName;
    private string $phoneNumber;

    public function __construct(
        string $id,
        string $firstname,
        string $lastname,
        string $password,
        string $repeatedPassword,
        string $companyEmail,
        string $companyName,
        string $phoneNumber
    ) {
        $this->employerid = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;
        $this->repeatedPassword = $repeatedPassword;
        $this->companyEmail = $companyEmail;
        $this->companyName = $companyName;
        $this->phoneNumber = $phoneNumber;
    }

    // Getter functions
    public function getEmployerId(): string {
        return $this->employerid;
    }

    public function getFirstname(): string {
        return $this->firstname;
    }

    public function getLastname(): string {
        return $this->lastname;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getRepeatedPassword(): string {
        return $this->repeatedPassword;
    }

    public function getCompanyEmail(): string {
        return $this->companyEmail;
    }

    public function getCompanyName(): string {
        return $this->companyName;
    }

    public function getPhoneNumber(): string {
        return $this->phoneNumber;
    }
}

?>
