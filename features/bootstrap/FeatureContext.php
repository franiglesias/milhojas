<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\MonthWeekSchedule;
use Milhojas\Domain\Cantine\RegularCantineUser;
use Milhojas\Domain\Cantine\CantineUserManager;
use Milhojas\Domain\Cantine\CantineUserRepository;
use PHPUnit\Framework\Assert;

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
      $this->CantineUserManager = new CantineUserManager();
    }

    /**
     * @Given there is a CantineUserManager
     */
    public function thereIsACantineusermanager()
    {
        $this->CantineUserManager = new CantineUserManager();
    }
    /**
     * @Given Student with StudentId :student_id which provides an schedule
     */
    public function studentWithStudentidWhichProvidesAnSchedule($student_id, TableNode $table)
    {
        $this->Student = new Student(new StudentId($student_id));
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
        // throw new PendingException();
    }

    /**
     * @When He applies to Cantine as RegularCantineUser
     */
    public function heAppliesToCantineAsRegularcantineuser()
    {
        $this->CantineUserManager->applyAsRegular($this->Student, $this->schedule);
    }

    /**
     * @Then A CantineUser with StudentId :student_id and schedule should be created
     */
    public function aCantineuserWithStudentidAndScheduleShouldBeCreated($student_id)
    {
        $user = $this->CantineUserManager->applyAsRegular(new Student(new StudentId($student_id)), $this->schedule);
        \PHPUnit_Framework_Assert::assertInstanceOf('Milhojas\Domain\Cantine\RegularCantineUser', $user);
    }

    /**
     * @Then That CantineUser is added to CantineUsers Repository
     */
    public function thatCantineuserIsAddedToCantineusersRepository()
    {
        throw new PendingException();
    }

    /**
  * @Then RegularCantineUserWasCreated event will be raised by CantineUserManager
  */
 public function regularcantineuserwascreatedEventWillBeRaisedByCantineusermanager()
 {
     throw new PendingException();
 }

 /**
  * @Given Student with StudentId :arg1 which provides a new schedule
  */
 public function studentWithStudentidWhichProvidesANewSchedule($arg1, TableNode $table)
 {
     throw new PendingException();
 }

 /**
  * @Given there is a RegularCantineUser with StudentId :arg1 and schedule
  */
 public function thereIsARegularcantineuserWithStudentidAndSchedule($arg1, TableNode $table)
 {
     throw new PendingException();
 }

 /**
  * @When Student with StudentId :arg1 applies to Cantine as RegularCantineUser
  */
 public function studentWithStudentidAppliesToCantineAsRegularcantineuser($arg1)
 {
     throw new PendingException();
 }

 /**
  * @Then CantineUser with StudentId :arg1 will update schedule to
  */
 public function cantineuserWithStudentidWillUpdateScheduleTo($arg1, TableNode $table)
 {
     throw new PendingException();
 }

 /**
  * @Then RegularCantineUserUpdatedScheduled event will be raised by CantineUserManager
  */
 public function regularcantineuserupdatedscheduledEventWillBeRaisedByCantineusermanager()
 {
     throw new PendingException();
 }

}
