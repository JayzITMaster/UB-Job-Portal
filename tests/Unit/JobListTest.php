<?php

use PHPUnit\Framework\TestCase;

class JobListTest extends TestCase
{
    public function testAddJobAndGetJobList(): void
    {
        $jobList = new JobList();

        // Test initial state (empty list)
        $this->assertEmpty($jobList->getjoblist());

        // Add jobs
        $jobList->addJob("Job 1");
        $jobList->addJob("Job 2");

        // Test updated state (with added jobs)
        $this->assertCount(2, $jobList->getjoblist());
        $this->assertContains("Job 1", $jobList->getjoblist());
        $this->assertContains("Job 2", $jobList->getjoblist());
    }
}
