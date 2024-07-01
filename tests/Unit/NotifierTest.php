<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class NotifierTest extends TestCase
{
    public function testAddNotification()
    {
        $notifier = new Notifier();

        $notifier->addNotification("Notification 1");
        $notifier->addNotification("Notification 2");

        $notifications = $notifier->getNotifications();

        // Assert that both notifications were added
        $this->assertCount(2, $notifications);

        // Assert the contents of notifications array
        $this->assertEquals("Notification 1", $notifications[0]);
        $this->assertEquals("Notification 2", $notifications[1]);
    }

    public function testGetNotifications()
    {
        $notifier = new Notifier();

        $notifier->addNotification("Notification 1");
        $notifier->addNotification("Notification 2");

        $notifications = $notifier->getNotifications();

        // Assert that getNotifications returns an array
        $this->assertIsArray($notifications);

        // Assert the contents of notifications array
        $this->assertEquals("Notification 1", $notifications[0]);
        $this->assertEquals("Notification 2", $notifications[1]);
    }

    // public function testGetNotificationsFailure()
    // {
    //     $notifier = new Notifier();

    //     $notification1 = 'Notification 1';
    //     $notification2 = 'Notification 2';

    //     $notifier->addNotification($notification1);
    //     $notifier->addNotification($notification2);

    //     // Intentionally set the wrong expected value
    //     $expected = ['Incorrect Notification'];

    //     // This assertion should fail because the returned notifications should not match the incorrect expected value
    //     $this->assertEquals($expected, $notifier->getNotifications());
    // } 




}

?>
