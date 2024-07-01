<?php

class JobPostHandler{
    private JobPost $jobpost;

    function __construct(JobPost $jobpost)
    {
        $this->jobpost = $jobpost;
    }

    public function checkFields(){ //return a string if error, return true if all is ok
        $logger = New Logger();
        $logger->info("Checking job post fields in ".__METHOD__);
        $this->checkJobPostContent();
        //perhaps do more checks but this shall suffice for now
        $logger->info("Job Post fields checked and is ok ".__METHOD__);
        return true;
    }
    
    private function checkJobPostContent() {
        $logger = New Logger();
        if (empty($this->jobpost->getTitle())) {
            $logger->error("Empty field job post title");
            throw New Exception("Empty field job post title");
            
        }
        if (empty($this->jobpost->getBody())) {
            $logger->error("Empty field job post body");
            throw New Exception("Empty field job post body");
        }
    }
}