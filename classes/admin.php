<?php


class Admin{
    private string $username;
    private string $email;

    public function __construct(string $username, string $email) {
        $this->username = $username;
        $this->email = $email;
    }

    // Getter functions
    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    // Setter functions
    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getAdminInfo(): array {
        return [
            'username' => $this->username,
            'email' => $this->email
        ];
    }
}