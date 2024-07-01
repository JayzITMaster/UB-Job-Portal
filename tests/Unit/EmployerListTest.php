<?php

use PHPUnit\Framework\TestCase;

class EmployerListTest extends TestCase
{
    public function testAddEmployerAndGetEmployers(): void
    {
        $employerList = new EmployerList();

        // Test initial state (empty list)
        $this->assertEmpty($employerList->getEmployers());

        // Add employers
        $employerList->addEmployer("Employer 1");
        $employerList->addEmployer("Employer 2");

        // Test updated state (with added employers)
        $this->assertCount(2, $employerList->getEmployers());
        $this->assertContains("Employer 1", $employerList->getEmployers());
        $this->assertContains("Employer 2", $employerList->getEmployers());
    }
}
