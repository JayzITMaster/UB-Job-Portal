<?php

$response["rc"] = -1;
        $response["message"] = "Could not create application with jobid: $jobid and applicantid $applicantid";
        try {
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
        $response["message"] = "Application created. Jobid: $jobid; Applciantod: $applicantid";
        $this->log->info("Successful application.");
        return $response;