<?php

class Notifier{
    private array $notifications = [];

    // Add notification to the notifications array
    public function addNotification(string $notification): void {
        $this->notifications[] = $notification;
    }

    // Get all notifications
    public function getNotifications(): array {
        return $this->notifications;
    }
}
