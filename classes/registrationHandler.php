<?php

use PhpParser\Builder\Method;

class RegistrationHandler
{
    private $userToRegister;
    private Logger $logger;

    function __construct($user)
    {
        $this->logger = new Logger();
        $this->logger->info("Registration Handler created" . __METHOD__);
        if ($user instanceof Applicant) {
            $this->userToRegister = $user;
        } elseif ($user instanceof Employer) {
            $this->userToRegister = $user;
        } else {
            throw new InvalidArgumentException("Registration Handler received neither class Applicant or Employer");
        }
        // $this->logger->info(memory_get_usage().__METHOD__);
    }

    public function checkFields()
    {
        // $this->logger->info("start of checkfields(): ".memory_get_usage().__METHOD__);
        $this->logger->info("checking the input fields" . __METHOD__);
        if ($this->userToRegister instanceof Applicant || $this->userToRegister instanceof Employer) {
            $this->checkEmptyFields();
            $this->containsInvalidCharacters();
            $this->passwordMatch();
            $this->checkForInvalidStringLengths();
            $this->logger->info("Field check successful");
            //return true on no errors
            return true;
        } else {
            throw new InvalidArgumentException("Cannot check fields of invalid class type. Expected Employer or Applicant in " . __METHOD__);
            return false;
        }
    }

    private function containsInvalidCharacters()
    {
        // Define the regex pattern for valid characters
        $validCharsRegex = 'a-zA-Z0-9 '; // This allows only alphanumeric characters        
        // Invert the regex to match characters that are NOT in the validCharsRegex
        $invalidCharsRegex = '/[^' . $validCharsRegex . ']/';
        if ($this->userToRegister instanceof Employer) {
            if (preg_match($invalidCharsRegex, $this->userToRegister->getFirstname())) {
                throw new Exception("Invalid characters found in employer first name");
            }
            if (preg_match($invalidCharsRegex, $this->userToRegister->getLastname())) {
                throw new Exception("Invalid characters found in employer last name");
            }
            if (preg_match($invalidCharsRegex, $this->userToRegister->getCompanyName())) {
                throw new Exception("Invalid characters found in the company name. Received " . $this->userToRegister->getCompanyName());
            }
            $this->ensureIsValidEmail($this->userToRegister->getCompanyEmail());
        } else if ($this->userToRegister instanceof Applicant) {
            if (preg_match($invalidCharsRegex, $this->userToRegister->getFirstName())) {
                throw new Exception("Invalid characters found in the applicant first name. Received " . $this->userToRegister->getFirstName());
            }
            if (preg_match($invalidCharsRegex, $this->userToRegister->getLastName())) {
                throw new Exception("Invalid characters found in the applicant last name. Received " . $this->userToRegister->getLastName());
            }
            $this->ensureIsValidEmail($this->userToRegister->getEmail());
            $this->ensureIsValidStudentId($this->userToRegister->getstudentId());
        } else {
            throw new InvalidArgumentException("Cannot check fields of invalid class type. Expected Employer or Applicant");
        }
        $this->logger->info("No Invalid characters in value strings" . __METHOD__);
    }

    private function checkForInvalidStringLengths()
    {
        $this->logger = new Logger();
        $minPasswordLength = 5;
        $maxNameLength = 20;
        $maxEmailLength = 60;
        $firstname = $this->userToRegister->getFirstname();
        $lastname = $this->userToRegister->getLastname();
        $password = $this->userToRegister->getPassword();

        if ($this->userToRegister instanceof Employer) {
            $maxCompanyNameLength = 40;
            $companyName = $this->userToRegister->getCompanyName();
            $companyEmail = $this->userToRegister->getCompanyEmail();
            if (strlen($firstname) > $maxNameLength) {
                throw new Exception("Invalid character count in employer first name. Expected characters: ", $maxNameLength);
            }
            if (strlen($lastname) > $maxNameLength) {
                throw new Exception("Invalid character count in employer last name. Expected characters: ", $maxNameLength);
            }
            if (strlen($companyName) > $maxCompanyNameLength) {
                throw new Exception("Invalid character count in the company name. Expected characters: ", $maxCompanyNameLength);
            }
            if (strlen($companyEmail) > $maxEmailLength) {
                throw new Exception("Invalid character count in the company email. Max characters: ", $maxEmailLength);
            }
            if (strlen($password) < $minPasswordLength) {
                throw new Exception("Invalid character count in the password. Expected characters: ", $minPasswordLength);
            }
        } else if ($this->userToRegister instanceof Applicant) {
            $maxNameLength = 30;
            $email = $this->userToRegister->getEmail();
            if (strlen($firstname) > $maxNameLength) {
                throw new Exception("Invalid character count in applicant first name. Expected characters: ", $maxNameLength);
            }
            if (strlen($lastname) > $maxNameLength) {
                throw new Exception("Invalid character count in applicant last name. Expected characters: ", $maxNameLength);
            }
            if (strlen($email) > $maxEmailLength) {
                throw new Exception("Invalid character count in the applicant email. Max characters: ", $maxEmailLength);
            }
            if (strlen($password) < $minPasswordLength) {
                throw new Exception("Invalid character count in the password. Expected characters: ", $minPasswordLength);
            }
        } else {
            throw new InvalidArgumentException("Cannot check fields of invalid class type. Expected Employer or Applicant in ", __METHOD__);
        }
        $this->logger->info("No Invalid string length on user registration" . __METHOD__);
    }

    private function passwordMatch()
    {
        $this->logger = new Logger();
        if ($this->userToRegister->getPassword() != $this->userToRegister->getRepeatedPassword()) {
            $this->logger->info("Registration passwords do not match" . __METHOD__);
            throw new Exception("Passwords do not match");
        }
        $this->logger->info("Passwords match");
    }

    private function ensureIsValidEmail(string $email): void
    {
        $this->logger = new Logger();
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                sprintf(
                    '"%s" is not a valid email address',
                    $email
                )
            );
            return;
        }
        $this->logger->info("Email is valid" . __METHOD__);
    }

    private function ensureIsValidStudentId(string $id)
    {
        $this->logger = new Logger();
        if (strlen($id) != 10 || !is_string($id)) {
            throw new Exception("Invalid Student ID: ".strlen($id));
        }

        $this->logger->info("Student Id is valid" . __METHOD__);
    }

    private function checkEmptyFields()
    {

        if ($this->userToRegister instanceof Employer) {
            // Check if any of the variables are empty
            if (empty($this->userToRegister->getFirstname())) {
                throw new Exception("Value for employer first name is empty");
            }
            if (empty($this->userToRegister->getLastname())) {
                throw new Exception("Value for employer last name is empty");
            }
            if (empty($this->userToRegister->getPassword())) {
                throw new Exception("Value for employer password is empty");
            }
            if (empty($this->userToRegister->getRepeatedPassword())) {
                throw new Exception("Value for employer repeated Password is empty");
            }
            if (empty($this->userToRegister->getCompanyEmail())) {
                throw new Exception("Value for company Email is empty");
            }
            if (empty($this->userToRegister->getCompanyName())) {
                throw new Exception("Value for company Name is empty");
            }
            if (empty($this->userToRegister->getPhoneNumber())) {
                throw new Exception("Value for phone Number is empty");
            }
        } else if ($this->userToRegister instanceof Applicant) {
            if (empty($this->userToRegister->getFirstName())) {
                throw new Exception("Value for applicant firstname is empty");
            }
            if (empty($this->userToRegister->getLastname())) {
                throw new Exception("Value for applicant lastname is empty");
            }
            if (empty($this->userToRegister->getEmail())) {
                throw new Exception("Value for applicant email is empty");
            }
            if (empty($this->userToRegister->getPassword())) {
                throw new Exception("Value for applicant password is empty");
            }
            if (empty($this->userToRegister->getRepeatedPassword())) {
                throw new Exception("Value for applicant repeatedPassword is empty");
            }
        } else {
            throw new InvalidArgumentException("Cannot check fields of invalid class type. Expected Employer or Applicant in ", __METHOD__);
        }

        $this->logger = new Logger();
        $this->logger->info("No fields are empty" . __METHOD__);
    }
}
