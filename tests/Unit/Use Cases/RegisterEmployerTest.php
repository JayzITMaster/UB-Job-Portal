<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class RegisterEmployerTest extends TestCase
{
    public function testCanRegisterNewEmployerWithValidDetails(): void
    {
        //create the instance of the employer
        $newEmployer = new Employer("", "Candy", "Bennett", "password", "password", "candy@gmail.com", "Candy Industries", "12345678");
        $controller = new APIController();
        $result = $controller->registerUser($newEmployer);
        $this->assertSame($result[0]->getNotifications()[0], "Employer is registered");
        $this->assertSame($result[1], true);
    }
    public function testCannotRegisterNewEmployerWithInvalidEmail(): void
    {
        //create the instance of the employer
        $newEmployer = new Employer("", "Candy", "Bennett", "password", "password", "candygmail.com", "Candy Industries", "12345678");
        $controller = new APIController();
        // Assert that an exception is thrown when trying to register the employer
        $this->expectException(InvalidArgumentException::class);
        $result = $controller->registerUser($newEmployer);
    }
    public function testCannotRegisterNewEmployerWithInvalidNames(): void
    {
        //create the instance of the employer
        $newEmployer = new Employer("", "Candy", "Bennett", "password", "password", "candy@gmail.com", "Candy^Industries", "12345678");
        $controller = new APIController();
        // Assert that an exception is thrown when trying to register the employer
        $this->expectException(Exception::class);
        $result = $controller->registerUser($newEmployer);
    }
    public function testCannotRegisterNewEmployerWithPasswordMismatch(): void
    {
        //create the instance of the employer
        $newEmployer = new Employer("", "Candy", "Bennett", "password", "password123", "candy@gmail.com", "Candy Industries", "12345678");
        $controller = new APIController();
        // Assert that an exception is thrown when trying to register the employer
        $this->expectException(Exception::class);
        $result = $controller->registerUser($newEmployer);
    }
}
