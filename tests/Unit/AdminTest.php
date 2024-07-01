<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    public function testConstructor()
    {
        $username = 'admin_user';
        $email = 'admin@example.com';

        $admin = new Admin($username, $email);

        $this->assertInstanceOf(Admin::class, $admin); // Check if the object is an instance of the Admin class
        $this->assertEquals($username, $admin->getUsername()); // Check if username attribute is set correctly
        $this->assertEquals($email, $admin->getEmail()); // Check if email attribute is set correctly
    }

    public function testGetAdminInfo()
    {
        $username = 'admin_user';
        $email = 'admin@example.com';

        $admin = new Admin($username, $email);

        $expected = [
            'username' => $username,
            'email' => $email
        ];

        $this->assertEquals($expected, $admin->getAdminInfo()); // Check if getAdminInfo returns expected output
    }

    public function testGetAdminInfoEmailMismatch()
    {
        $username = 'admin_user';
        $email = 'admin@example.com';
    
        // Create an Admin instance with a different email
        $admin = new Admin($username, 'admin@example.com');
    
        $expected = [
            'username' => $username,
            'email' => $email
        ];
    
        // This assertion should fail because the email returned by getAdminInfo doesn't match the expected email
        $this->assertEquals($expected, $admin->getAdminInfo());
    }
}


?>
