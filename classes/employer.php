<?php


class Employer
{
    private $employerid;
    private $companyName;
    private $recruiter_firstname;
    private $recruiter_lastname;
    private $profile_picture;
    private $email;
    private $password;
    private $phoneNumber;
    private $hashedPassword;
    private $repeatedPassword;
    private $companyEmail;
    private $created_at;
    public function __construct($id, $companyName, $recruiter_firstname, $recruiter_lastname, $email, $password, $repeatedPassword, $phoneNumber)
    {
        $this->employerid = $id;
        $this->companyName = $companyName;
        $this->recruiter_firstname = $recruiter_firstname;
        $this->recruiter_lastname = $recruiter_lastname;
        $this->email = $email;
        $this->password = $password;
        $this->repeatedPassword = $repeatedPassword;
        $this->phoneNumber = $phoneNumber;
    }
    function hashPassword($password)
    {
        // Hash the password using bcrypt algorithm
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($hashedPassword === false) {
            // Hashing failed
            throw new Exception('Password hashing failed');
        }
        return $hashedPassword;
    }

    public function getEmployerid(){
        return $this->employerid;
    }
    public function getCompanyName(){
        return $this->companyName;
    }
    public function getRecruiter_firstname(){
        return $this->recruiter_firstname;
    }
    public function getRecruiter_lastname(){
        return $this->recruiter_lastname;
    }
    public function getProfile_picture(){
        return $this->profile_picture;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getPhoneNumber(){
        return $this->phoneNumber;
    }
    public function getHashedPassword(){
        return $this->hashedPassword;
    }
    public function getRepeatedPassword(){
        return $this->repeatedPassword;
    }
    public function getCompanyEmail(){
        return $this->companyEmail;
    }
    public function getCreated_at(){
        return $this->created_at;
    }
}
