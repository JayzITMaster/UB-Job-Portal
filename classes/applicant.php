<?php
class Applicant
{

    private string $id;
    private string $firstname;
    private string $lastname;
    private string $studentid;
    private string $email;
    private string $password;
    private string $repeatedPassword;
    private string $hashedPassword;

    public function __construct(string $id, string $studentid, string $firstname, string $lastname,  string $email, string $password, string $repeatedPassword)
    {
        $this->id = $id;
        $this->studentid = $studentid;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->hashedPassword = $this->hashPassword($password);
        $this->repeatedPassword = $repeatedPassword;
    }
    function hashPassword($password) {
        // Hash the password using bcrypt algorithm
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($hashedPassword === false) {
            // Hashing failed
            throw new Exception('Password hashing failed');
        }
        return $hashedPassword;
    }
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getApplicantId(): string
    {
        return $this->id;
    }
    public function getStudentid(): string
    {
        return $this->studentid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getRepeatedPassword(): string
    {
        return $this->repeatedPassword;
    }

    // Setter functions
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setStudentid(string $studentid): void
    {
        $this->studentid = $studentid;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRepeatedPassword(string $repeatedPassword): void
    {
        $this->repeatedPassword = $repeatedPassword;
    }

    public function getApplicantInfo(): array
    {
        return [
            'id' => $this->id,
            'studentid' => $this->studentid,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
            'repeatedPassword' => $this->repeatedPassword
        ];
    }
}
