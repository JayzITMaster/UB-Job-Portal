<?php

class EmployerList
{
    private $employers;
    public function __construct()
    {
        $this->employers = array(); // Initialize the list as an empty array
    }
    public function addEmployer($employer)// Function to add an employer to the list
    {
        $this->employers[] = $employer;
    }
    public function getEmployers()// Function to return the list of employers
    {
        return $this->employers;
    }
}
