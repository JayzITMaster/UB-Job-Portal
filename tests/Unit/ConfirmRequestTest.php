<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class ConfirmRequestTest extends TestCase
{
    public function testSetConfirmRequestValues(): void
    {
        $confirmRequest = new ConfirmRequest();

        // Test initial state (null)
        $this->assertNull($confirmRequest->getOption());

        // Set option to true
        $confirmRequest->setOption(true);
        $this->assertTrue($confirmRequest->getOption());

        // Set option to false
        $confirmRequest->setOption(false);
        $this->assertFalse($confirmRequest->getOption());
    }
}
