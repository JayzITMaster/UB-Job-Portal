<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class AuthenticationTest extends TestCase
{
    public function testDisablingAnEmployerWithValidId(): void
    {
        //create the instance of the employer
        $controller = new APIController();
        $result = $controller->deleteEmployer("22");
        $this->assertSame($result[0]->getNotifications()[0], "Employer deleted");
        $this->assertSame($result[1], true);
    }
    public function testDisablingAnEmployerWithInvalidId(): void
    {
        $controller = new APIController();
        $result = $controller->deleteEmployer("1000");
        $this->assertSame($result[0]->getNotifications()[0], "Employer deleted");
        $this->assertSame($result[1], true);
    }
    public function testDisablingAnEmployerWithnNegativeId(): void
    {
        //create the instance of the employer
        $controller = new APIController();
        $result = $controller->deleteEmployer("-4");
        $this->assertSame($result[0]->getNotifications()[0], "Employer deleted");
        $this->assertSame($result[1], true);
    }
}
