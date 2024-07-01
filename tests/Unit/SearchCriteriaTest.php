<?php

declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class SearchCriteriaTest extends TestCase
{
    public function testConstructor()
    {
        $internship = true;
        $fulltime = false;
        $parttime = true;
        $remote = false;

        $searchCriteria = new SearchCriteria($internship, $fulltime, $parttime, $remote);

        $this->assertInstanceOf(SearchCriteria::class, $searchCriteria); // Check if the object is an instance of the SearchCriteria class
        $this->assertEquals($internship, $searchCriteria->isInternship()); // Check if internship attribute is set correctly
        $this->assertEquals($fulltime, $searchCriteria->isFulltime()); // Check if fulltime attribute is set correctly
        $this->assertEquals($parttime, $searchCriteria->isParttime()); // Check if parttime attribute is set correctly
        $this->assertEquals($remote, $searchCriteria->isRemote()); // Check if remote attribute is set correctly
    }

    public function testGetSearchCriteriaList()
    {
        $internship = true;
        $fulltime = false;
        $parttime = true;
        $remote = false;

        $searchCriteria = new SearchCriteria($internship, $fulltime, $parttime, $remote);

        $expected = [
            'internship' => $internship,
            'fulltime' => $fulltime,
            'parttime' => $parttime,
            'remote' => $remote
        ];

        $this->assertEquals($expected, $searchCriteria->getSearchCriteriaList()); // Check if getSearchCriteriaList returns correct value
    }
}

?>
