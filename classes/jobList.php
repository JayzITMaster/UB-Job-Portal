<?php

class JobList
{
    private $jobs;
    public function __construct()
    {
        $this->jobs = array(); // Initialize the list as an empty array
    }
    public function addJob($job)// Function to add an joblist to the list
    {
        $this->jobs[] = $job;
    }
    public function getjoblist()// Function to return the list of joblist
    {
        return $this->jobs;
    }
}