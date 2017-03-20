<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Context;
use Milhojas\Domain\Cantine\TicketRegistrar;
use Milhojas\Domain\Cantine\Event\CantineUserBoughtTickets;
use Milhojas\Domain\Cantine\Event\CantineUserTriedToBuyInvalidTicket;
use Milhojas\Domain\Cantine\Exception\CantineUserNotFound;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Cantine\CantineGroup;
use Milhojas\Domain\Cantine\CantineUser;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Domain\Utils\Schedule\MonthWeekSchedule;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\Messaging\CommandBus\CommandBus;
use Milhojas\Messaging\EventBus\EventBus;
use Prophecy\Prophet;
use Prophecy\Argument;

/**
 * Defines application features from the specific context.
 */
class StudentsUsingCantineContext implements Context
{
    private $prophet;
    private $student_name;
    private $cantineUser;
    private $dispatcher;
    private $CantineUserRepository;
    private $TicketRegistrar;

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
        $this->CantineUserRepository = new CantineUserInMemoryRepository();
        $this->TicketRegistrar = $this->prophet->prophesize(TicketRegistrar::class);
        $this->dispatcher = $this->prophet->prophesize(EventBus::class);
        $this->bus = $this->prophet->prophesize(CommandBus::class);
    }

    /**
     * @Given There is a Student called :student_name
     */
    public function thereIsAStudentCalled($student_name)
    {
        list($name, $surname) = explode(' ', $student_name);
        $this->student_name = sprintf('%s, %s', $surname, $name);
    }

    /**
     * @Given Student is not registered as Cantine User
     */
    public function CantineUserNotFound()
    {
        $this->cantineUser = $this->getNewCantineUserNamed($this->student_name);
        $this->CantineUserRepository->store($this->cantineUser);
    }

    /**
     * @When Student buys a ticket to eat on date :date
     */
    public function studentBuysATicketToEatOnDate($date)
    {
        $days = new ListOfDates([$date]);
        $this->cantineUser->buysTicketFor($days);
        $this->dispatcher->dispatch(new CantineUserBoughtTickets($this->cantineUser, $days));
    }

    /**
     * @Then Student should be assigned to a CantineGroup
     */
    public function studentShouldBeAssignedToACantinegroup()
    {
        $this->cantineUser->assignToGroup(new CantineGroup('Test group'));
        if (!$this->cantineUser->belongsToGroup(new CantineGroup('Test group'))) {
            throw new \Exception('User was not assigned to group.');
        }
    }

    /**
     * @Then Student should be registered as Cantine User
     */
    public function studentShouldBeRegisteredAsCantineUser()
    {
        $this->CantineUserRepository->store($this->cantineUser);
    }

    /**
     * @Then A ticket for date :date should be registered
     */
    public function aTicketForDateShouldBeRegistered($date)
    {
        $day = new ListOfDates([$date]);
        $this->dispatcher->dispatch(CantineUserBoughtTickets::class)->shouldBeCalled();
        $this->TicketRegistrar->register($this->cantineUser, $day)->shouldBeCalled();
    }

    /**
     * @Then Student should be eating on date :date
     */
    public function studentShouldBeEatingOnDate($date)
    {
        if (!$this->cantineUser->isEatingOnDate($date)) {
            throw new \Exception('Cantine User is not eating on ticket date.');
        }
    }

    /**
     * @Given Student is registered as Cantine User
     */
    public function studentIsRegisteredAsCantineUser()
    {
        $this->cantineUser = $this->getNewCantineUserNamed($this->student_name);
    }

    /**
     * @When Student buys a ticket to eat on date :date that he has scheduled
     */
    public function studentBuysATicketToEatOnDateThatHeHasScheduled($date)
    {
        $days = new ListOfDates([$date]);

        try {
            $this->cantineUser->buysTicketFor($days);
            $this->dispatcher->dispatch(new CantineUserBoughtTickets($this->cantineUser, $days));
        } catch (Exception $e) {
            throw new \Exception('Checking of previous schedule has failed!');
        }
    }

    /**
     * @Then No ticket should be registered
     */
    public function noTicketShouldBeRegistered()
    {
        $this->dispatcher->dispatch(CantineUserBoughtTickets::class)->shouldNotBeCalled();
        $this->TicketRegistrar->register(Argument::any(), Argument::any())->shouldNotBeCalled();
    }

    /**
     * @Then A notification should be send
     */
    public function aNotificationShouldBeSend()
    {
        $this->dispatcher->dispatch(new CantineUserTriedToBuyInvalidTicket($this->CantineUser));
    }

    /**
     * @When Student buys tickets to eat on dates
     */
    public function studentBuysTicketsToEatOnDates($dates)
    {
        $this->cantineUser->buysTicketFor($dates);
        $this->dispatcher->dispatch(new CantineUserBoughtTickets($this->cantineUser, $dates));
    }

    /**
     * @Then Student should be eating on dates
     */
    public function studentShouldBeEatingOnDates($dates)
    {
        foreach ($dates as $date) {
            if (!$this->cantineUser->isEatingOnDate($date)) {
                throw new \Exception("Eating dates doesn't match with schedule");
            }
        }
    }

    /**
     * @Then tickets should be registered for dates
     */
    public function ticketsShouldBeRegisteredForDates($dates)
    {
        $event = new CantineUserBoughtTickets($this->cantineUser, $dates);
        $this->dispatcher->dispatch($event)->shouldBeCalled();
        $this->TicketRegistrar->register($this->cantineUser, $dates)->shouldBeCalled();
    }

    /**
     * @When Student applies to Cantine with schedule
     */
    public function studentAppliesToCantineWithSchedule(MonthWeekSchedule $schedule)
    {
        $this->cantineUser = $this->getNewCantineUserNamed($this->student_name, $schedule);
    }

    /**
     * @Given Student is registered as Cantine User with a schedule
     */
    public function studentIsRegisteredAsCantineUserWithASchedule(MonthWeekSchedule $schedule)
    {
        $this->cantineUser = $this->getNewCantineUserNamed($this->student_name, $schedule);
    }

    private function studentAppliesToCantine(Student $student, $schedule = null)
    {
        return CantineUser::apply(
            $student->getPlainId(),
            $student->getPerson()->getListName(),
            $student->getClass()->getShortName(),
            $student->getClass()->getStageName(),
            $schedule
        );
    }

    private function getNewCantineUserNamed($listname, $schedule = null)
    {
        return CantineUser::apply(
            'user-01',
            $listname,
            'Test class',
            'Test Stage',
            $schedule
        );
    }

    /**
     * @Then Student should not be eating on dates
     */
    public function studentShouldNotBeEatingOnDates(ListOfDates $dates)
    {
        foreach ($dates as $date) {
            if ($this->cantineUser->isEatingOnDate($date)) {
                throw new \Exception("Eating dates doesn't match with schedule");
            }
        }
    }

    /**
     * @When Student modifies its schedule with
     */
    public function studentModifiesItsScheduleWith(MonthWeekSchedule $schedule)
    {
        $this->cantineUser->updateSchedule($schedule);
    }

    /**
     * @Transform :date
     */
    public function castToDate($date)
    {
        return new \DateTime($date);
    }

    /**
     * @Transform table:dates
     */
    public function castToListOfDates(TableNode $dates)
    {
        $dates = $dates->getColumn(0);
        array_shift($dates);
        $dates = array_map(function ($date) {
            return new \DateTime($date);
        }, $dates);

        return new ListOfDates($dates);
    }

    /**
     * @Transform table:month,weekdays
     */
    public function castToCantineSchedule(TableNode $dates)
    {
        foreach ($dates->getHash() as $row) {
            $schedule[$row['month']] = explode(', ', $row['weekdays']);
        }

        return new MonthWeekSchedule($schedule);
    }
}
