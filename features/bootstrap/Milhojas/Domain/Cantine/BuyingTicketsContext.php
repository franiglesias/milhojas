<?php

namespace Milhojas\Domain\Cantine;

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Milhojas\Application\Cantine\Command\RegisterStudentAsCantineUser;
use Milhojas\Domain\Cantine\Event\CantineUserBoughtTickets;
use Milhojas\Domain\Cantine\Event\CantineUserTriedToBuyInvalidTicket;
use Milhojas\Domain\Cantine\Exception\StudentIsNotRegisteredAsCantineUser;
use Milhojas\Domain\Cantine\Specification\AssociatedCantineUser;
use Milhojas\Domain\School\Student;
use Milhojas\Domain\School\StudentId;
use Milhojas\Domain\Utils\Schedule\ListOfDates;
use Milhojas\Infrastructure\Persistence\Cantine\CantineUserInMemoryRepository;
use Milhojas\Library\Collections\Checklist;
use Milhojas\Library\CommandBus\CommandBus;
use Milhojas\Library\EventBus\EventBus;
use Milhojas\Library\ValueObjects\Identity\PersonName;
use Prophecy\Prophet;
use Prophecy\Argument;

/**
 * Defines application features from the specific context.
 */
class BuyingTicketsContext implements SnippetAcceptingContext
{
    private $prophet;
    private $student;
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
        $this->student = $this->prophet->prophesize(Student::class);
        $this->student->getStudentId()->willReturn(new StudentId('student-01'));
        list($name, $surname) = explode(' ', $student_name);
        $this->student->getName()->willReturn(new PersonName($name, $surname));
        $this->student->getAllergies()->willReturn(new Allergens(new Checklist(['this', 'that'])));
    }

    /**
     * @Given Student is not registered as Cantine User
     */
    public function studentIsNotRegisteredAsCantineUser()
    {
        try {
            $this->cantineUser = $this->CantineUserRepository->get(new AssociatedCantineUser($this->student->reveal()));
        } catch (StudentIsNotRegisteredAsCantineUser $e) {
            $this->cantineUser = CantineUser::apply($this->student->reveal());
        }
    }

    /**
     * @When Student buys a ticket to eat on date :date
     */
    public function studentBuysATicketToEatOnDate($date)
    {
        $days = new ListOfDates([$date]);
        $this->cantineUser->buysTicketFor($days);
        $this->dispatcher->handle(new CantineUserBoughtTickets($this->cantineUser, $days));
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
        $this->bus->execute(new RegisterStudentAsCantineUser($this->student->reveal()));
    }

    /**
     * @Then A ticket for date :date should be registered
     */
    public function aTicketForDateShouldBeRegistered($date)
    {
        $day = new ListOfDates([$date]);
        $this->dispatcher->handle(CantineUserBoughtTickets::class)->shouldBeCalled();
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
        $this->cantineUser = CantineUser::apply($this->student->reveal());
    }

    /**
     * @When Student buys a ticket to eat on date :date that he has scheduled
     */
    public function studentBuysATicketToEatOnDateThatHeHasScheduled($date)
    {
        $days = new ListOfDates([$date]);

        try {
            $this->cantineUser->buysTicketFor($days);
            $this->dispatcher->handle(new CantineUserBoughtTickets($this->cantineUser, $days));
        } catch (Exception $e) {
            throw new \Exception('Checking of previous schedule has failed!');
        }
    }

    /**
     * @Then No ticket should be registered
     */
    public function noTicketShouldBeRegistered()
    {
        $this->dispatcher->handle(CantineUserBoughtTickets::class)->shouldNotBeCalled();
        $this->TicketRegistrar->register(Argument::any(), Argument::any())->shouldNotBeCalled();
    }

    /**
     * @Then A notification should be send
     */
    public function aNotificationShouldBeSend()
    {
        $this->dispatcher->handle(new CantineUserTriedToBuyInvalidTicket($this->CantineUser));
    }

    /**
     * @When Student buys tickets to eat on dates
     */
    public function studentBuysTicketsToEatOnDates($dates)
    {
        $this->cantineUser->buysTicketFor($dates);
        $this->dispatcher->handle(new CantineUserBoughtTickets($this->cantineUser, $dates));
    }

    /**
     * @Then Student should be eating on dates
     */
    public function studentShouldBeEatingOnDates($dates)
    {
        foreach ($dates as $date) {
            if (!$this->cantineUser->isEatingOnDate($date)) {
                throw new \Exception("Eating dates doesn't match with tickets bought");
            }
        }
    }

    /**
     * @Then tickets should be registered for dates
     */
    public function ticketsShouldBeRegisteredForDates($dates)
    {
        $event = new CantineUserBoughtTickets($this->cantineUser, $dates);
        $this->dispatcher->handle($event)->shouldBeCalled();
        $this->TicketRegistrar->register($this->cantineUser, $dates)->shouldBeCalled();
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
}