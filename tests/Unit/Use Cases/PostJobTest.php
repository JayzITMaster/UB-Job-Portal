<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PostJobTest extends TestCase
{
    public function testPostAJobWithValidDetails(): void
    {
        $newPost = new JobPost("", "Job Title", "Job Body; this will be paragraphs of text");
        $controller = new APIController();
        $result = $controller->newJobPost($newPost);
        $this->assertSame($result[0]->getNotifications()[0], "Job Post Created");
        $this->assertTrue($result[1]); //checks if true was returned
        $this->assertIsInt($result[2]); //checks if a valid ID was returned for the newly added job post
    }
    public function testPostAJobWithInvalidJobTitle(): void
    {
        $newPost = new JobPost("", "", "Job Body; this will be paragraphs of text");
        $controller = new APIController();
        $this->expectException(Exception::class);
        $result = $controller->newJobPost($newPost);
        $this->assertSame($result[0]->getNotifications()[0], "Job Post Created");
        $this->assertTrue($result[1]); //checks if true was returned
        $this->assertIsInt($result[2]); //checks if a valid ID was returned for the newly added job post
    }
    public function testPostAJobWithInvalidJobDescription(): void
    {
        $newPost = new JobPost("", "Job Title", "");
        $controller = new APIController();
        $this->expectException(Exception::class);
        $result = $controller->newJobPost($newPost);
        $this->assertSame($result[0]->getNotifications()[0], "Job Post Created");
        $this->assertTrue($result[1]); //checks if true was returned
        $this->assertIsInt($result[2]); //checks if a valid ID was returned for the newly added job post
    }

}
