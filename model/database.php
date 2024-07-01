<?php

include "../includes/dbh.inc.php";

class Model extends SQLHandler
{
    private $getApplicationsQuery = "SELECT a.id AS applicant_id, a.firstname, a.lastname, a.description AS applicant_description, a.studentID, a.email, a.resume_doc, a.profile_picture,
    j.job_id, j.title AS job_title, j.description AS job_description, j.details_doc, 
    jt.job_type,
    l.location,
    c.category,
    e.profile_picture AS employer_profile_picture,
    e.company_name,
    e.email AS employer_email, 
    e.phone_number AS employer_phone_number, 
    app.created_at
    FROM applications AS app
    INNER JOIN applicants AS a
    ON app.applicant_id = a.id
    INNER JOIN jobs AS j
    ON app.job_id = j.job_id
    INNER JOIN employers AS e
    ON j.employer_id = e.id
    INNER JOIN job_types AS jt
    ON j.job_type_id = jt.id
    INNER JOIN categories AS c
    ON j.category_id = c.id
    INNER JOIN locations AS l
    ON j.location_id = l.id ";

    // protected function registerUserInDB($user)
    // {
    //     if ($user instanceof Employer) {
    //         $result = $this->createEmployerInDB($user);
    //         return $result;
    //     } else if ($user instanceof Applicant) {
    //         $result = $this->createApplicantInDB($user);
    //         return $result;
    //     } else {
    //         throw new InvalidArgumentException("Cannot register user. Received invalid class type in ", __METHOD__);
    //     }
    // }


    //Job Functions
    protected function createJobPostInDB($employerid, $title, $description, $location_id, $category_id, $details_doc, $job_type_id)
    {
        $logger = new Logger();
        $response = ["rc" => -1, "message" => "Failed to create job"];
        try {
            $query = "INSERT INTO jobs (title, description, employer_id, location_id, category_id, details_doc, job_type_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $this->log->debug("createJob query: " . $query);

            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("Lost database connection");
                return $response;
            }

            // Bind parameters to the query
            $stmt->bind_param("ssiiisi", $title, $description, $employerid, $location_id, $category_id, $details_doc, $job_type_id);
            $stmt->send_long_data(5, $details_doc); // Ensure this is used for large binary data

            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error creating job";
                $this->log->error("Query execution error for creating job");
                return $response;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        $inserted_id = $this->sqlDB->insert_id;
        $insertedData = $this->getJobWithIdFromDb($inserted_id);
        $logger->info("last inserted record for post is $inserted_id");
        $response["rc"] = 1;
        $response["message"] = "Job created successfully: job id: $inserted_id";
        $response["data"] = $insertedData["data"];
        return $response;
    } //done
    protected function deleteJobWithIdFromDb($id)
    {
        $response["rc"] = -1;
        $response["message"] = "Invalid Delete Request";
        $jobData = $this->getJobWithIdFromDb($id);
        if ($jobData["rc"] == -1) {
            $response["message"] = $jobData["message"];
            return $response;
        }
        try {
            $query = "DELETE FROM jobs WHERE job_id = ?;";
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("i", $id);

                $deletedData = $this->getJobWithIdFromDb($id);
                if ($stmt->execute()) {
                    $stmt->close();
                    $response["rc"] = 1;
                    $response["message"] = "Job deleted with id $id";
                    $response["data"] = $deletedData["data"];
                    $this->log->info("job deleted with id $id");
                } else {
                    $stmt->close();
                    $response["rc"] = -1;
                    $response["message"] = "Error deleting job with id $id";
                    $this->log->error("query execution error for deleting a job with given ID $id");
                    return $response;
                }
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        return $response;
    } //done
    protected function updateJobWithIdFromDb($id, $title, $description, $location_id, $category_id, $details_doc, $job_type_id)
    {
        $response["rc"] = -1;
        $response["message"] = "Job Details Not Found for id $id";

        try {
            //see if there is a record with that id first
            $databeforeUpdate = $this->getJobWithIdFromDb($id);
            if ($databeforeUpdate["rc"] == -1) {
                $response["rc"] = -1;
                $response["message"] = $databeforeUpdate["message"];
                return $response;
            }

            $query = "UPDATE jobs SET title = ?, description = ?, location_id = ?, category_id = ?, details_doc = ?, job_type_id = ? WHERE job_id = ?;";
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("ssiisii", $title, $description, $location_id, $category_id, $details_doc, $job_type_id, $id);
                // Handle large binary data
                if ($details_doc !== null) {
                    $stmt->send_long_data(4, $details_doc); // Note: Use the correct index for the profile picture (index 3)
                }
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error updating job with id $id";
                $this->log->error("query execution error for updating job with id $id");
                return $response;
            }
            $affected_rows = $stmt->affected_rows;
            $stmt->close();
            $response["rc"] = 1;
            if ($affected_rows > 0) {
                $response["message"] = "Job with ID $id updated successfully. 1 row affected";
                $this->log->info("Successful update for job with ID $id. 1 row affected");
            } else {
                //there were not affected rows but the query execution was still successful
                $response["message"] = "Job with ID $id updated successfully. No rows affected";
                $this->log->info("Successful update for job with ID $id. No rows affected");
            }
            $updatedData = $this->getJobWithIdFromDb($id);
            $response["data"] = $updatedData["data"];
            $response["data_old"] = $databeforeUpdate["data"];
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        return $response;
    } //done
    protected function getJobsFromDb()
    {
        $response["rc"] = -1;
        $response["message"] = "No Jobs' Details Found";
        try {
            $query = "SELECT J.job_id, J.created_at, J.title, J.description, J.employer_id, E.company_name, J.location_id, L.location, J.category_id, C.category, J.job_type_id, JT.job_type
            FROM jobs AS J
            INNER JOIN employers as E
            ON J.employer_id = E.id
            INNER JOIN locations AS L
            ON J.location_id = L.id
            INNER JOIN categories AS C
            ON J.category_id = C.id
            INNER JOIN job_types AS JT
            ON J.job_type_id = JT.id;";
            $this->log->debug("getJobs query: " . $query);
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error getting Jobs";
                $this->log->error("query execution error for getting all jobs");
                return $response;
            }
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $response["rc"] = -1;
                $response["message"] = "Error reading records for jobs";
                $this->log->debug("error: no results retreived");
                $stmt = null;
                return $response;
            }
            while ($row = $result->fetch_assoc()) {
                $response["data"][] = $row;
            }
            $this->log->info("Successful request execution. Got all jobs.");
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        $response["rc"] = 1;
        $response["message"] = "Found jobs from the database.";
        // $this->log->debug(var_dump($response));
        return $response;
    } //done
    protected function getJobWithIdFromDb($id)
    {
        $response["rc"] = -1;
        $response["message"] = "Job Details Not Found for id $id";
        try {
            $query = "SELECT J.job_id, J.created_at, J.title, J.description, J.employer_id, E.company_name, J.location_id, L.location, J.category_id, C.category, J.job_type_id, JT.job_type, J.details_doc
            FROM jobs AS J
            INNER JOIN employers as E
            ON J.employer_id = E.id
            INNER JOIN locations AS L
            ON J.location_id = L.id
            INNER JOIN categories AS C
            ON J.category_id = C.id
            INNER JOIN job_types AS JT
            ON J.job_type_id = JT.id
            WHERE job_id = ?;";
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("i", $id);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error getting job with id $id";
                $this->log->error("query execution error for getting job with id $id");
                return $response;
            }
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error reading job record of provided ID: $id";
                $this->log->debug("error: no results received");
                return $response;
            }
            while ($row = $result->fetch_assoc()) {
                if (isset($row['details_doc'])) {
                    // Convert binary data to base64 string
                    $row['details_doc'] = base64_encode($row['details_doc']);
                }
                $response["data"][] = $row;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        $response["rc"] = 1;
        $response["message"] = "Found job with provided id: $id in the database.";
        $this->log->info("Successful request execution. Got job with provided id: $id.");
        return $response;
    } //done

    //-------------------------------------------------------------------------

    //Employer Functions
    protected function getEmployersFromDb()
    {
        try {
            $response["rc"] = -1; //default fail
            $response["message"] = "No Employers' Details Found";
            $query = "SELECT company_name, recruiter_firstname, recruiter_lastname, email, phone_number FROM employers;";
            $this->log->debug("getEmployers query: " . $query);
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error getting Employers";
                $this->log->error("query execution error for getting all employers");
                return $response;
            }
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $response["rc"] = -1;
                $response["message"] = "Error reading records for employers";
                $this->log->debug("error: no results retreived");
                $stmt = null;
                return $response;
            }
            while ($row = $result->fetch_assoc()) {
                $response["data"][] = $row;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        $response["rc"] = 1;
        $response["message"] = "Found employers from the database.";
        $this->log->info("Successful request execution. Got all employers.");
        return $response;
    } //done
    protected function getEmployerWithIdFromDb($id)
    {
        $response["rc"] = -1;
        $response["message"] = "Employer Details Not Found for id $id";
        try {
            $query = "SELECT company_name, recruiter_firstname, recruiter_lastname, profile_picture, email, phone_number FROM employers WHERE id = ?;";
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("i", $id);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error getting employer with id $id";
                $this->log->error("query execution error for getting employer with id $id");
                return $response;
            }
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error reading employer record of provided ID: $id";
                $this->log->debug("error: no results received");
                return $response;
            }
            while ($row = $result->fetch_assoc()) {
                if (isset($row['profile_picture'])) {
                    // Convert binary data to base64 string
                    $row['profile_picture'] = base64_encode($row['profile_picture']);
                }
                $response["data"][] = $row;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        $response["rc"] = 1;
        $response["message"] = "Found employer with provided id: $id in the database.";
        $this->log->info("Successful request execution. Got employer with provided id: $id.");
        return $response;
    } //done
    protected function updateEmployerWithIdFromDb($id, $companyName, $recruiterFirstname, $recruiterLastname, $email, $phoneNumber, $profile_picture)
    {
        $response["rc"] = -1;
        $response["message"] = "Employer Details Not Found for id $id";
        try {
            //see if there is a record with that id first
            $databeforeUpdate = $this->getEmployerWithIdFromDb($id);
            if ($databeforeUpdate["rc"] == -1) {
                $response["rc"] = -1;
                $response["message"] = $databeforeUpdate["message"];
                return $response;
            }

            $query = "UPDATE employers SET company_name = ?, recruiter_firstname = ?, recruiter_lastname = ?, profile_picture = ?, email = ?, phone_number = ? WHERE id = ?;";
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("ssssssi", $companyName, $recruiterFirstname, $recruiterLastname, $profile_picture, $email, $phoneNumber, $id);
                // Handle large binary data
                if ($profile_picture !== null) {
                    $stmt->send_long_data(3, $profile_picture); // Note: Use the correct index for the profile picture (index 3)
                }
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error updating employer with id $id";
                $this->log->error("query execution error for updating employer with id $id");
                return $response;
            }
            $affected_rows = $stmt->affected_rows;
            $stmt->close();
            $response["rc"] = 1;
            if ($affected_rows > 0) {
                $response["message"] = "Employer with ID $id updated successfully. 1 row affected";
                $this->log->info("Successful update for employer with ID $id. 1 row affected");
            } else {
                //there were not affected rows but the query execution was still successful
                $response["message"] = "Employer with ID $id updated successfully. No rows affected";
                $this->log->info("Successful update for employer with ID $id. No rows affected");
            }
            $updatedData = $this->getEmployerWithIdFromDb($id);
            $response["data"] = $updatedData["data"];
            $response["data_old"] = $databeforeUpdate["data"];
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        // $this->log->debug(var_dump($response));
        return $response;
    } //done
    protected function deleteEmployerWithIdFromDb($id)
    {
        $response["rc"] = -1;
        $response["message"] = "Invalid Delete Request";
        $employerData = $this->getEmployerWithIdFromDb($id);
        if ($employerData["rc"] == -1) {
            $response["message"] = $employerData["message"];
            return $response;
        }
        try {
            $query = "DELETE FROM employers WHERE id = ?;";
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("i", $id);

                $deletedData = $this->getEmployerWithIdFromDb($id);
                if ($stmt->execute()) {
                    $stmt->close();
                    $response["rc"] = 1;
                    $response["message"] = "Employer deleted with id $id";
                    $response["data"] = $deletedData["data"];
                    $this->log->info("Employer deleted with id $id");
                } else {
                    $stmt->close();
                    $response["rc"] = -1;
                    $response["message"] = "Error deleting employer with id $id";
                    $this->log->error("query execution error for deleting a employer with given ID $id");
                    return $response;
                }
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        return $response;
    } //done
    protected function createEmployerInDb($companyName, $recruiterFirstname, $recruiterLastname, $email, $password, $phoneNumber)
    {
        $logger = new Logger();
        $response = ["rc" => -1, "message" => "Failed to create employer"];
        try {
            $query = "INSERT INTO employers (company_name, recruiter_firstname, recruiter_lastname, email, password, phone_number, role) 
            VALUES (?, ?, ?, ?, ?, ?, 1)";
            $this->log->debug("create employer query: " . $query);

            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("Lost database connection");
                return $response;
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ssssss", $companyName, $recruiterFirstname, $recruiterLastname, $email, $hashedPassword, $phoneNumber);
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error creating employer";
                $this->log->error("Query execution error for creating employer");
                return $response;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        $inserted_id = $this->sqlDB->insert_id;
        $insertedData = $this->getEmployerWithIdFromDb($inserted_id);
        $logger->info("last inserted record for employer is $inserted_id");
        $response["rc"] = 1;
        $response["message"] = "Employer created successfully: job id: $inserted_id";
        $response["data"] = $insertedData["data"];
        return $response;
    } //done

    //-------------------------------------------------------------------------

    //Applicant Functions
    protected function getApplicantsFromDb()
    {
        try {
            $response["rc"] = -1; //default fail
            $response["message"] = "No Applicants' Details Found";
            $query = "SELECT firstname, lastname, description, studentID, email, resume_doc FROM applicants;";
            $this->log->debug("getApplicants query: " . $query);
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error getting Applicants";
                $this->log->error("query execution error for getting all applicants");
                return $response;
            }
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $response["rc"] = -1;
                $response["message"] = "Error reading records for applicants";
                $this->log->debug("error: no results retreived");
                $stmt = null;
                return $response;
            }
            while ($row = $result->fetch_assoc()) {
                if (isset($row['profile_picture'])) {
                    // Convert binary data to base64 string
                    $row['profile_picture'] = base64_encode($row['profile_picture']);
                }
                if (isset($row['resume_doc'])) {
                    // Convert binary data to base64 string
                    $row['resume_doc'] = base64_encode($row['resume_doc']);
                }
                $response["data"][] = $row;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        $response["rc"] = 1;
        $response["message"] = "Found applicants from the database.";
        $this->log->info("Successful request execution. Got all applicants.");
        return $response;
    } //done
    protected function getApplicantWithIdFromDb($id)
    {
        $response["rc"] = -1;
        $response["message"] = "Employer Details Not Found for id $id";
        try {
            $query = "SELECT firstname, lastname, profile_picture, description, studentID, email, password, phone_number, resume_doc FROM applicants WHERE id = ?;";
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("i", $id);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error getting applicant with id $id";
                $this->log->error("query execution error for getting applicant with id $id");
                return $response;
            }
            $result = $stmt->get_result();
            if ($result->num_rows === 0) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error reading applicant record of provided ID: $id";
                $this->log->debug("error: no results received");
                return $response;
            }
            while ($row = $result->fetch_assoc()) {
                if (isset($row['profile_picture'])) {
                    // Convert binary data to base64 string
                    $row['profile_picture'] = base64_encode($row['profile_picture']);
                }
                if (isset($row['resume_doc'])) {
                    // Convert binary data to base64 string
                    $row['resume_doc'] = base64_encode($row['resume_doc']);
                }
                $response["data"][] = $row;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        $response["rc"] = 1;
        $response["message"] = "Found applicant with provided id: $id in the database.";
        $this->log->info("Successful request execution. Got applicant with provided id: $id.");
        return $response;
    } //done
    protected function updateApplicantWithIdFromDb($id, $firstname, $lastname, $profile_picture, $description, $studentId, $email, $phoneNumber, $resume)
    {
        $response["rc"] = -1;
        $response["message"] = "Applicant Details Not Found for id $id";
        try {
            //see if there is a record with that id first
            $databeforeUpdate = $this->getApplicantWithIdFromDb($id);
            if ($databeforeUpdate["rc"] == -1) {
                $response["rc"] = -1;
                $response["message"] = $databeforeUpdate["message"];
                return $response;
            }

            $query = "UPDATE applicants SET firstname = ?, lastname = ?, profile_picture = ?, description = ?, studentID = ?, email = ?, phone_number = ?, resume_doc = ? WHERE id = ?;";
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("ssssisssi", $firstname, $lastname, $profile_picture, $description, $studentId, $email, $phoneNumber, $resume, $id);
                // Handle large binary data
                if ($profile_picture !== null) {
                    $stmt->send_long_data(2, $profile_picture); // Note: Use the correct index for the profile picture (index 3)
                }
                if ($resume !== null) {
                    $stmt->send_long_data(7, $resume); // Note: Use the correct index for the profile picture (index 3)
                }
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error updating applicant with id $id";
                $this->log->error("query execution error for updating applicant with id $id");
                return $response;
            }
            $affected_rows = $stmt->affected_rows;
            $stmt->close();
            $response["rc"] = 1;
            if ($affected_rows > 0) {
                $response["message"] = "Applicant with ID $id updated successfully. 1 row affected";
                $this->log->info("Successful update for applicant with ID $id. 1 row affected");
            } else {
                //there were not affected rows but the query execution was still successful
                $response["message"] = "Applicant with ID $id updated successfully. No rows affected";
                $this->log->info("Successful update for applicant with ID $id. No rows affected");
            }
            $updatedData = $this->getApplicantWithIdFromDb($id);
            $response["data"] = $updatedData["data"];
            $response["data_old"] = $databeforeUpdate["data"];
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        // $this->log->debug(var_dump($response));
        return $response;
    } //done
    protected function deleteApplicantWithIdFromDb($id)
    {
        $response["rc"] = -1;
        $response["message"] = "Invalid Delete Request";
        $employerData = $this->getApplicantWithIdFromDb($id);
        if ($employerData["rc"] == -1) {
            $response["message"] = $employerData["message"];
            return $response;
        }
        try {
            $query = "DELETE FROM applicants WHERE id = ?;";
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("i", $id);

                $deletedData = $this->getApplicantWithIdFromDb($id);
                if ($stmt->execute()) {
                    $stmt->close();
                    $response["rc"] = 1;
                    $response["message"] = "Applicant deleted with id $id";
                    $response["data"] = $deletedData["data"];
                    $this->log->info("Applicant deleted with id $id");
                } else {
                    $stmt->close();
                    $response["rc"] = -1;
                    $response["message"] = "Error deleting applicant with id $id";
                    $this->log->error("query execution error for deleting a applicant with given ID $id");
                    return $response;
                }
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        return $response;
    } //done
    protected function createApplicantInDB($firstname, $lastname, $studentId, $email, $password, $phoneNumber)
    {
        $logger = new Logger();
        $response = ["rc" => -1, "message" => "Failed to create applicant"];
        try {
            $query = "INSERT INTO applicants (firstname, lastname, studentID, email, password, phone_number, role) 
                VALUES (?, ?, ?, ?, ?, ?, 3)";
            $this->log->debug("create applicant query: " . $query);

            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("Lost database connection");
                return $response;
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("ssssss", $firstname, $lastname, $studentId, $email, $password, $phoneNumber);
            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error creating applicant";
                $this->log->error("Query execution error for creating applicant");
                return $response;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }
        $inserted_id = $this->sqlDB->insert_id;
        $insertedData = $this->getApplicantWithIdFromDb($inserted_id);
        $logger->info("last inserted record for applicant is $inserted_id");
        $response["rc"] = 1;
        $response["message"] = "Applicant created successfully: applicant id: $inserted_id";
        $response["data"] = $insertedData["data"];
        return $response;
    } //done

    //-------------------------------------------------------------------------

    //Application Functions

    protected function getApplicationsWithApplicantIdFromDb($id)
    {
        $response["rc"] = -1;
        $response["message"] = "Application Details Not Found for id $id";
        try {
            $query = $this->getApplicationsQuery . " WHERE a.id = ?;";
            $this->log->info("running jointed query: " . $query);
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("i", $id);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }

            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error getting application with id $id";
                $this->log->error("query execution error for getting application with id $id");
                return $response;
            }

            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error reading application record of provided ID: $id";
                $this->log->debug("error: no results received");
                return $response;
            }
            while ($row = $result->fetch_assoc()) {
                if (isset($row['employer_profile_picture'])) {
                    // Convert binary data to base64 string
                    $row['employer_profile_picture'] = base64_encode($row['employer_profile_picture']);
                }
                if (isset($row['profile_picture'])) {
                    // Convert binary data to base64 string
                    $row['profile_picture'] = base64_encode($row['profile_picture']);
                }
                if (isset($row['resume_doc'])) {
                    // Convert binary data to base64 string
                    $row['resume_doc'] = base64_encode($row['resume_doc']);
                }
                if (isset($row['details_doc'])) {
                    // Convert binary data to base64 string
                    $row['details_doc'] = base64_encode($row['details_doc']);
                }
                $response["data"][] = $row;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }

        $response["rc"] = 1;
        $response["message"] = "Found application with provided id: $id in the database.";
        $this->log->info("Successful request execution. Got applications with provided job id: $id.");
        return $response;
    } //done
    protected function getApplicationsWithJobIdFromDb($id)
    {
        $response["rc"] = -1;
        $response["message"] = "Application Details Not Found for id $id";
        try {
            $query = $this->getApplicationsQuery . " WHERE j.job_id = ?;";
            $this->log->info("running jointed query: " . $query);
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("i", $id);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }

            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error getting application with id $id";
                $this->log->error("query execution error for getting application with id $id");
                return $response;
            }

            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error reading application record of provided ID: $id";
                $this->log->debug("error: no results received");
                return $response;
            }
            while ($row = $result->fetch_assoc()) {
                if (isset($row['employer_profile_picture'])) {
                    // Convert binary data to base64 string
                    $row['employer_profile_picture'] = base64_encode($row['employer_profile_picture']);
                }
                if (isset($row['profile_picture'])) {
                    // Convert binary data to base64 string
                    $row['profile_picture'] = base64_encode($row['profile_picture']);
                }
                if (isset($row['resume_doc'])) {
                    // Convert binary data to base64 string
                    $row['resume_doc'] = base64_encode($row['resume_doc']);
                }
                if (isset($row['details_doc'])) {
                    // Convert binary data to base64 string
                    $row['details_doc'] = base64_encode($row['details_doc']);
                }
                $response["data"][] = $row;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }

        $response["rc"] = 1;
        $response["message"] = "Found application with provided id: $id in the database.";
        $this->log->info("Successful request execution. Got applications with provided job id: $id.");
        return $response;
    } //done
    protected function getApplicationWithIdFromDb($id)
    {
        $response["rc"] = -1;
        $response["message"] = "Application Details Not Found for id $id";
        try {
            $query = $this->getApplicationsQuery . " WHERE app.id = ?;";
            $this->log->info("running jointed query: " . $query);
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $stmt->bind_param("i", $id);
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }

            if (!$stmt->execute()) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error getting application with id $id";
                $this->log->error("query execution error for getting application with id $id");
                return $response;
            }

            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                $stmt = null;
                $response["rc"] = -1;
                $response["message"] = "Error reading application record of provided ID: $id";
                $this->log->debug("error: no results received");
                return $response;
            }
            while ($row = $result->fetch_assoc()) {
                if (isset($row['profile_picture'])) {
                    // Convert binary data to base64 string
                    $row['profile_picture'] = base64_encode($row['profile_picture']);
                }
                if (isset($row['employer_profile_picture'])) {
                    // Convert binary data to base64 string
                    $row['employer_profile_picture'] = base64_encode($row['employer_profile_picture']);
                }
                if (isset($row['resume_doc'])) {
                    // Convert binary data to base64 string
                    $row['resume_doc'] = base64_encode($row['resume_doc']);
                }
                if (isset($row['details_doc'])) {
                    // Convert binary data to base64 string
                    $row['details_doc'] = base64_encode($row['details_doc']);
                }
                $response["data"][] = $row;
            }
            $stmt->close();
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }

        $response["rc"] = 1;
        $response["message"] = "Found application with provided id: $id in the database.";
        $this->log->info("Successful request execution. Got application with provided id: $id.");
        return $response;
    } //done
    protected function createApplicationInDb($jobid, $applicantid)
    {
        $response["rc"] = -1;
        $response["message"] = "Could not create application with jobid: $jobid and applicantid $applicantid; ";
        try {
            //see if there is a record with that id first
            $dataForJob = $this->getJobWithIdFromDb($jobid);
            if ($dataForJob["rc"] == -1) {
                $response["rc"] = -1;
                $response["message"] = $response["message"] . $dataForJob["message"];
                return $response;
            }
            //see if there is a record with that id first
            $dataForJob = $this->getApplicantWithIdFromDb($applicantid);
            if ($dataForJob["rc"] == -1) {
                $response["rc"] = -1;
                $response["message"] = $response["message"] . $dataForJob["message"];
                return $response;
            }
            $logger = new Logger();
            $query = "INSERT INTO `applications` (`job_id`, `applicant_id`) VALUES (?, ?);";
            $this->log->info("running query: " . $query);
            if ($this->sqlDB !== null) {
                $stmt = $this->sqlDB->prepare($query);
                $result = $stmt->execute(array($jobid, $applicantid));
                if ($result === false) {
                    $error = "Error executing query " . $this->sqlDB->error;
                    $logger->error($error);
                    $stmt = null;
                    $response["rc"] = -1;
                    $error = "Error inserting to database for new application";
                    $response["message"] = $error;
                    $this->log->error("$error");
                    return $response;
                } else {
                    $this->info("Query executed successfully");
                }
            } else {
                $response["rc"] = -1;
                $response["message"] = "No database connection";
                $this->log->error("lost database connection");
                return $response;
            }
        } catch (Exception $e) {
            $response["rc"] = -1;
            $response["message"] = "Error: " . $e->getMessage();
            $this->log->error("Error: " . $e->getMessage());
            return $response;
        }

        $response["rc"] = 1;
        $response["message"] = "Application created. Jobid: $jobid; Applicantid: $applicantid";
        $this->log->info("Successful application.");
        return $response;
    } //done

//-------------------------------------------------------------------------

    //Account Functions
    protected function loginUser($email, $password){
        
    }
}
