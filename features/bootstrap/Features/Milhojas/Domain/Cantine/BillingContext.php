<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\Utils\Schedule\MonthWeekSchedule;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\Domain\Cantine\Specification\BillableThisMonth;
use League\Period\Period;

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
            $User = CantineUser::apply(
                $row['student_id'],
                sprintf('%s, %s', $row['surname'], $row['name']),
                $row['class'],
                substr($row['class'], 0, strpos($row['class'], ' ')),
                $schedule);
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
        $this->result = [];
        foreach ($billable as $user) {
            $days = $user->getBillableDaysOn($month);
            $this->result[] = [
                'student' => $user->getListName(),
                'days' => $days,
                'amount' => $this->priceList[$days],
            ];
        }
    }

    /**
     * @Transform :month
     */
    public function castMonthToPeriod($month)
    {
        list($month, $year) = explode(' ', $month);
        $date = new \DateTime('1st '.$month.' '.$year);
        $month = $date->format('m');

        return Period::createFromMonth($year, $month);
    }

    /**
     * @Then I should get a list of users like this
     */
    public function iShouldGetAListOfUsersLikeThis(TableNode $table)
    {
        if ($this->result != $table->getHash()) {
            throw new \Exception('Billing info doesn\'t match');
        }
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
