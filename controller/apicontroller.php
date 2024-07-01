<?php

include "../model/database.php";

class APIController extends Model
{

    // $this->sqlDB; //holds the database connection
    // public function registerUser($user)
    // {
    //     // $this->info(memory_get_usage().__METHOD__);
    //     $logger = new Logger();
    //     $this->info("Registering a user" . __METHOD__);
    //     // try {
    //     $registrationHandler = new RegistrationHandler($user);
    //     $result = $registrationHandler->checkFields();
    //     if ($result) {
    //         if ($user instanceof Employer) {
    //             //do the database action
    //             $result = $this->registerUserInDB($user);
    //             $notifier = new Notifier();
    //             if ($result) {
    //                 // Use the Notifier to display message as a notification
    //                 $notifier->addNotification("Employer is registered");
    //                 $logger->info("register success: notifiier is (" . $notifier->getNotifications()[0] . ")");
    //                 return [$notifier, true];
    //             }
    //         } else if ($user instanceof Applicant) {
    //             //do the database action
    //             $result = $this->registerUserInDB($user);
    //             $notifier = new Notifier();
    //             if ($result) {
    //                 // Use the Notifier to display the error message as a notification
    //                 $notifier->addNotification("Applicant is registered");
    //                 $logger->info("register success: notifiier is (" . $notifier->getNotifications()[0] . ")");
    //                 return [$notifier, true];
    //             }
    //         }
    //     }
    //     // } catch (Exception $e) {
    //     //     // Catch the exception and get the error message
    //     //     $errorMessage = $e->getMessage();
    //     //     $logger->error($e->getMessage());
    //     //     // Create an instance of the Notifier class
    //     //     $notifier = new Notifier();
    //     //     // Use the Notifier to display the error message as a notification
    //     //     $notifier->addNotification($errorMessage);
    //     //     return [$notifier, false];
    //     // }
    // }

    //Job Functions
    public function GetJobs()
    {
        $logger = new Logger();
        $logger->info("Getting all jobs " . __METHOD__);
        $response = $this->getJobsFromDb();
        return $response;
    }
    public function GetJobWithId($id)
    {
        $logger = new Logger();
        $logger->info("Getting a job with id $id " . __METHOD__);
        $response = $this->getJobWithIdFromDb($id);
        return $response;
    }
    public function UpdateJobWithId($id, $title, $description, $location_id, $category_id, $details_doc, $job_type_id)
    {
        $logger = new Logger();
        $logger->info("Updating job with $id " . __METHOD__);
        $response = $this->updateJobWithIdFromDb($id, $title, $description, $location_id, $category_id, $details_doc, $job_type_id);
        return $response;
    }
    public function DeleteJobWithId($id)
    {
        $logger = new Logger();
        $logger->info("Deleting a job with id $id " . __METHOD__);
        $response = $this->deleteJobWithIdFromDb($id);
        return $response;
    }
    public function createJob($id, $title, $description, $location_id, $category_id, $details_doc, $job_type_id)
    {
        $logger = new Logger();
        $logger->info("Creating job post");
        $response = $this->createJobPostInDB($id, $title, $description, $location_id, $category_id, $details_doc, $job_type_id);
        return $response;
    }


    // Employer Functions
    public function getEmployers()
    {
        $logger = new Logger();
        $logger->info("Getting all employers " . __METHOD__);
        $response = $this->getEmployersFromDb();
        return $response;
    }
    public function GetEmployerWithId($id)
    {
        $logger = new Logger();
        $logger->info("Getting an employer with id $id " . __METHOD__);
        $response = $this->getEmployerWithIdFromDb($id);
        return $response;
    }
    public function UpdateEmployerWithId($id, $companyName, $recruiterFirstname, $recruiterLastname, $email, $phoneNumber, $profile_picture)
    {
        $logger = new Logger();
        $logger->info("Updating employer with $id " . __METHOD__);
        $response = $this->updateEmployerWithIdFromDb($id, $companyName, $recruiterFirstname, $recruiterLastname, $email, $phoneNumber, $profile_picture);
        return $response;
    }
    public function DeleteEmployerWithId($id)
    {
        $logger = new Logger();
        $logger->info("Disabling/Deleting an employer with id $id " . __METHOD__);
        $response = $this->deleteEmployerWithIdFromDb($id);
        return $response;
    }
    public function createEmployer($companyName, $recruiterFirstname, $recruiterLastname, $email, $password, $repeatedPassword, $phoneNumber)
    {
        $logger = new Logger();
        $logger->info("Creating job post");
        $response = $this->createEmployerInDB($companyName, $recruiterFirstname, $recruiterLastname, $email, $password, $phoneNumber);
        return $response;
    }



    //Applicant Functions
    public function getApplicants()
    {
        $logger = new Logger();
        $logger->info("Getting all applicants " . __METHOD__);
        $response = $this->getApplicantsFromDb();
        return $response;
    }
    public function GetApplicantWithId($id)
    {
        $logger = new Logger();
        $logger->info("Getting an applicant with id $id " . __METHOD__);
        $response = $this->getApplicantWithIdFromDb($id);
        return $response;
    }
    public function UpdateApplicantWithId($id, $firstname, $lastname, $profile_picture, $description, $studentId, $email, $phoneNumber, $resume)
    {
        $logger = new Logger();
        $logger->info("Updating applicant with $id " . __METHOD__);
        $response = $this->updateApplicantWithIdFromDb($id, $firstname, $lastname, $profile_picture, $description, $studentId, $email, $phoneNumber, $resume);
        return $response;
    }
    public function DeleteApplicantWithId($id)
    {
        $logger = new Logger();
        $logger->info("Deleting an applicant with $id " . __METHOD__);
        $response = $this->deleteApplicantWithIdFromDb($id);
        return $response;
    }
    public function createApplicant($firstname, $lastname, $studentId, $email, $password, $repeatedPassword, $phoneNumber)
    {
        $logger = new Logger();
        $logger->info("Creating Applicant");
        $response = $this->createApplicantInDB($firstname, $lastname, $studentId, $email, $password, $phoneNumber);
        return $response;
    }


    // //Application Functions
    public function GetApplicationsWithApplicantId($id)
    {
        $logger = new Logger();
        $logger->info("Getting the applications made for a job with id $id " . __METHOD__);
        $response = $this->getApplicationsWithApplicantIdFromDb($id);
        return $response;
    }
    public function GetApplicationsWithJobId($id)
    {
        $logger = new Logger();
        $logger->info("Getting the applications made for a job with id $id " . __METHOD__);
        $response = $this->getApplicationsWithJobIdFromDb($id);
        return $response;
    }
    public function GetApplicationWithId($id)
    {
        $logger = new Logger();
        $logger->info("Getting an application with id $id " . __METHOD__);
        $response = $this->getApplicationWithIdFromDb($id);
        return $response;
    }
    public function createApplication($jobid, $applicantid)
    {
        $logger = new Logger();
        $logger->info("Creating job appliction for job with id $jobid , for applicant with id $applicantid" . __METHOD__);
        $response = $this->createApplicationInDb($jobid, $applicantid);
        return $response;
    }
    
    // Account Functions
    public function login($email, $password){
        //validate the email and the password
        
        $logger = new Logger();
        $logger->info("Attempting to login user");
        $response = $this->loginUser($email, $password);
        return $response;

    }
}
