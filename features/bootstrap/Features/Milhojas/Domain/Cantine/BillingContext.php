<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\Utils\Schedule\MonthWeekSchedule;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\LIbrary\ValueObjects\Identity\Person;

/**
 * Defines application features from the specific context.
 */
class BillingContext implements Context
{
    private $cantineUserRepostory;
    private $priceList;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->CantineUserRepository = new CantineUserInMemoryRepository();
    }

    /**
     * @Given There are some regular users
     */
    public function thereAreSomeRegularUsers(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            switch ($row['type']) {
                case 'regular':
                    $schedule = $this->buildMonthWeekSchedule($row);
                    break;
                case 'ticket':
                    $date = new \DateTime($row['schedule']);
                    $schedule = new ListOfDates([$date]);
                    break;
                default:
                    // code...
                    break;
            }
            $student = new Student(
                new StudentId($row['student_id']),
                new Person($row['name'], $row['surname'], $row['gender']),
                $row['class'],
                ''
            );
            $User = CantineUser::apply($student, $schedule);
            $User->assignToGroup(new CantineGroup($row['group']));
            $this->CantineUserRepository->store($User);
        }
    }

    /**
     * @Given prices are the following
     */
    public function pricesAreTheFollowing(TableNode $priceTable)
    {
        foreach ($priceTable->getHash() as $value) {
            $this->priceList[$value['days']] = $value['price'];
        }
    }

    /**
     * @When I generate bills for month :month
     */
    public function iGenerateBillsForMonth($month)
    {
        $billable = $this->CantineUserRepository->find(new BillableThisMonth($month));
        throw new PendingException();
    }

    /**
     * @Then I should get a list of users like this
     */
    public function iShouldGetAListOfUsersLikeThis(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * Convert a row of table data into a schedule.
     *
     * @param [type] $row [Description]
     *
     * @return MonthWeekSchedule
     */
    private function buildMonthWeekSchedule($row)
    {
        list($month, $weekdays) = explode(': ', $row['schedule']);
        $schedule = [$month => explode(', ', trim($weekdays))];

        return new MonthWeekSchedule($schedule);
    }
}
