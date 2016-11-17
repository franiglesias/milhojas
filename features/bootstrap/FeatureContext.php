<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\MonthWeekSchedule;
use Milhojas\Domain\Cantine\RegularCantineUser;

class StudentMock
{
    private $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getStudentId()
    {
        return $this->id;
    }
}
/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given Student with StudentId :student_id which provides an schedule
     */
    public function studentWithStudentidWhichProvidesAnSchedule($student_id, TableNode $table)
    {
        $this->Student = new StudentMock(new StudentId($student_id));
        $this->schedule = new MonthWeekSchedule($this->getSchedule($table));
    }

    private function getSchedule($table)
    {
        foreach ($table as $row) {
            $schedule[][$row['month']] = explode(', ', $row['weekdays']);
        }

        return $schedule;
    }

    /**
     * @Given There is no RegularCantineUser associated
     */
    public function thereIsNoRegularcantineuserAssociated()
    {
        throw new PendingException();
    }

    /**
     * @When He applies to Cantine as RegularCantineUser
     */
    public function heAppliesToCantineAsRegularcantineuser()
    {
        throw new PendingException();
    }

    /**
     * @Then A CantineUser with StudentId should be created
     */
    public function aCantineuserWithStudentidShouldBeCreated()
    {
        $this->regularCantineUser = new RegularCantineUser($this->Student->getStudentId(), $this->schedule);
        \PHPUnit_Framework_Assert::assertInstanceOf('Milhojas\Domain\Cantine\RegularCantineUser', $this->regularCantineUser);
    }

    /**
     * @Then That CantineUser is added to CantineUsers Repository
     */
    public function thatCantineuserIsAddedToCantineusersRepository()
    {
        throw new PendingException();
    }
}
