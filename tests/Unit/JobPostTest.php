<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class JobPostTest extends TestCase
{
    public function testConstructor()
    {
        $id = '2';
        $title = 'Software Engineer';
        $body = 'We are looking for a skilled software engineer to join our team.';

        $jobPost = new JobPost($id, $title, $body);

        $this->assertInstanceOf(JobPost::class, $jobPost); // Check if the object is an instance of the JobPost class
        $this->assertEquals($id, $jobPost->getId()); // Check if id attribute is set correctly
        $this->assertEquals($title, $jobPost->getTitle()); // Check if title attribute is set correctly
        $this->assertEquals($body, $jobPost->getBody()); // Check if body attribute is set correctly
    }

    public function testGetPost()
    {
        $id = '2';
        $title = 'Software Engineer';
        $body = 'We are looking for a skilled software engineer to join our team.';

        $jobPost = new JobPost($id, $title, $body);

        $expected = [
            'id' => $id,
            'title' => $title,
            'body' => $body
        ];

        $this->assertEquals($expected, $jobPost->getPost()); // Check if getPost returns expected output
    }
}

?>
