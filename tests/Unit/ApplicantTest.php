<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class ApplicantTest extends TestCase
{
    public function testConstructor()
    {
        $id = '';
        $studentid = '123456';
        $firstname = 'John';
        $lastname = 'Doe';
        $email = 'john@example.com';
        $password = 'password';
        $repeatedPassword = 'password';

        $applicant = new Applicant($id, $studentid, $firstname, $lastname,  $email, $password, $repeatedPassword);

        $this->assertInstanceOf(Applicant::class, $applicant); // Check if the object is an instance of the Applicant class
        $this->assertEquals($id, $applicant->getApplicantId()); // Check if firstname attribute is set correctly
        $this->assertEquals($firstname, $applicant->getFirstname()); // Check if firstname attribute is set correctly
        $this->assertEquals($lastname, $applicant->getLastname()); // Check if lastname attribute is set correctly
        $this->assertEquals($studentid, $applicant->getStudentid()); // Check if studentid attribute is set correctly
        $this->assertEquals($email, $applicant->getEmail()); // Check if email attribute is set correctly
        $this->assertEquals($password, $applicant->getPassword()); // Check if password attribute is set correctly
        $this->assertEquals($repeatedPassword, $applicant->getRepeatedPassword()); // Check if repeatedPassword attribute is set correctly
    }

    public function testGetApplicantInfo()
    {
        $id = '';
        $studentid = '123456';
        $firstname = 'John';
        $lastname = 'Doe';
        $email = 'john@example.com';
        $password = 'password';
        $repeatedPassword = 'password';

        $applicant = new Applicant($id, $studentid, $firstname, $lastname,  $email, $password, $repeatedPassword);

        $expected = [
            'id' => $id,
            'studentid' => $studentid,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $password,
            'repeatedPassword' => $repeatedPassword
        ];

        $this->assertEquals($expected, $applicant->getApplicantInfo()); // Check if getApplicantInfo returns expected output
    }
}

?>
