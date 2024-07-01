<?php


class SearchCriteria {
    private bool $internship;
    private bool $fulltime;
    private bool $parttime;
    private bool $remote;

    public function __construct(bool $internship, bool $fulltime, bool $parttime, bool $remote) {
        $this->internship = $internship;
        $this->fulltime = $fulltime;
        $this->parttime = $parttime;
        $this->remote = $remote;
    }

    // Getter functions
    public function isInternship(): bool {
        return $this->internship;
    }

    public function isFulltime(): bool {
        return $this->fulltime;
    }

    public function isParttime(): bool {
        return $this->parttime;
    }

    public function isRemote(): bool {
        return $this->remote;
    }

    // Setter functions
    public function setInternship(bool $internship): void {
        $this->internship = $internship;
    }

    public function setFulltime(bool $fulltime): void {
        $this->fulltime = $fulltime;
    }

    public function setParttime(bool $parttime): void {
        $this->parttime = $parttime;
    }

    public function setRemote(bool $remote): void {
        $this->remote = $remote;
    }

    public function getSearchCriteriaList(): array {
        return [
            'internship' => $this->internship,
            'fulltime' => $this->fulltime,
            'parttime' => $this->parttime,
            'remote' => $this->remote
        ];
    }
}
