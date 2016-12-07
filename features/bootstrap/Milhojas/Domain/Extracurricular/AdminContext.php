<?php

namespace Milhojas\Domain\Extracurricular;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Milhojas\Domain\Utils\Schedule\WeeklySchedule;
use Milhojas\Domain\School\Student;
use Milhojas\Infrastructure\Persistence\Extracurricular\ActivityInMemoryRepository;
use Prophecy\Prophet;

/**
 * Defines application features from the specific context.
 */
class AdminContext implements Context
{
    private $activity;
    private $catalogue;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->prophet = new Prophet();
        $this->catalogue = new ActivityInMemoryRepository();
        $this->extraCurricularManager = new ExtraCurricularManager($this->catalogue);
    }

    /**
     * @Given There is a new extracurricular activity :activity that will run on :time of :schedule
     */
    public function thereIsANewExtracurricularActivityThatWillRunOnOf($activity, $time, $schedule)
    {
        $this->activity[] = Activity::createFrom($activity, $time, $schedule);
    }

    /**
     * @When It is added to the catalogue
     */
    public function itIsAddedToTheCatalogue()
    {
        foreach ((array) $this->activity as $activity) {
            $this->catalogue->store($activity);
        }
    }

    /**
     * @Then Catalogue should have :count activity
     */
    public function catalogueShouldHaveActivity($count)
    {
        if ($this->catalogue->count() != $count) {
            throw new \Exception('Activity not added to catalogue');
        }
    }

    /**
     * @Given There is a new extracurricular activity :activity that have groups
     */
    public function thereIsANewExtracurricularActivityThatHaveGroups($activity, $groups)
    {
        foreach ($groups as $group => $params) {
            $this->activity[] = Activity::createFrom(sprintf('%s (%s)', $activity, $group), $params['time'], $params['schedule']);
        }
    }

    /**
     * @Then Catalogue should have :count activities
     */
    public function catalogueShouldHaveActivities($count)
    {
        if ($this->catalogue->count() != $count) {
            throw new \Exception('Activity not added to catalogue');
        }
    }

    /**
     * @Given There is a Student Called :student
     */
    public function thereIsAStudentCalled($student)
    {
        $this->student = $student;
    }

    /**
     * @Given There is an activity in the catalogue called :activity
     */
    public function thereIsAnActivityInTheCatalogueCalled($activity)
    {
        $activity = Activity::createFrom($activity, 'morning', new WeeklySchedule(['monday', 'wednesday']));
        $this->catalogue->store($activity);
    }

    /**
     * @When Student enrolls to activity :activity
     */
    public function studentEnrollsToActivity($activity)
    {
        $this->extraCurricularManager->enrollStudent($this->student->reveal(), $activity);
    }

    /**
     * @Then Activity :activity should be appended to Student's list of activities
     */
    public function activityShouldBeAppendedToStudentSListOfActivities($activity)
    {
        if (!$this->student->isEnrolledToExtracurricular($activity)) {
            throw new \Exception('Student enrollement failed');
        }
    }

    /**
     * @Transform :schedule
     */
    public function castToSchedule($schedule)
    {
        $days = preg_split('/[,\s]+/', $schedule);

        return new WeeklySchedule($days);
    }

    /**
     * @Transform table:group,time,schedule
     */
    public function castToGroupsList(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $groups[$row['group']] = [
                'time' => $row['time'],
                'schedule' => $this->castToSchedule($row['schedule']),
            ];
        }

        return $groups;
    }

    /**
     * @Transform :student
     */
    public function castToStudent($student_name)
    {
        $student = $this->prophet->prophesize(Student::class);

        return $student;
    }
}
