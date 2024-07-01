<?php


class JobPost {
    private string $id;
    private string $title;
    private string $body;
    private string $doc;

    public function __construct(string $id, string $title, string $body, string $doc) {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->doc = $doc;
    }

    // Getter functions
    public function getId(): string {
        return $this->id;
    }
    public function getTitle(): string {
        return $this->title;
    }

    public function getBody(): string {
        return $this->body;
    }
    public function getDoc(): string {
        return $this->doc;
    }

    // Setter functions
    public function setId(string $id): void {
        $this->title = $id;
    }
    public function setTitle(string $title): void {
        $this->title = $title;
    }
    public function setBody(string $body): void {
        $this->body = $body;
    }
    public function setDoc(string $doc): void {
        $this->doc = $doc;
    }

    public function getPost(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'doc' => $this->doc
        ];
    }
}
