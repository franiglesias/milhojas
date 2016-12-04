<?php

namespace Milhojas\Domain\Cantine;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class AdminApplicationContext implements Context
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
     * @Given There are some Cantine Users registered
     */
    public function thereAreSomeCantineUsersRegistered(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given turns are the following
     */
    public function turnsAreTheFollowing(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given groups are the following
     */
    public function groupsAreTheFollowing(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given Rules for turn assignation are
     */
    public function rulesForTurnAssignationAre(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given Today is :arg1
     */
    public function todayIs($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When Admin asks for the list
     */
    public function adminAsksForTheList()
    {
        throw new PendingException();
    }

    /**
     * @Then the list should contain this Cantine Users
     */
    public function theListShouldContainThisCantineUsers(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then the list should not contain this Cantine Users
     */
    public function theListShouldNotContainThisCantineUsers(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then the turns should be assigned as
     */
    public function theTurnsShouldBeAssignedAs(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given We sold :arg1 tickets on a day
     */
    public function weSoldTicketsOnADay($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given Every ticket costs 7.25€
     */
    public function everyTicketCostsEu()
    {
        throw new PendingException();
    }

    /**
     * @When We close the day
     */
    public function weCloseTheDay()
    {
        throw new PendingException();
    }

    /**
     * @Then Daily Income should be 217.5€
     */
    public function dailyIncomeShouldBeEu()
    {
        throw new PendingException();
    }

    /**
     * @Given This week we sold these tickets each day
     */
    public function thisWeekWeSoldTheseTicketsEachDay(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @When We close the week
     */
    public function weCloseTheWeek()
    {
        throw new PendingException();
    }

    /**
     * @Then Weekly Income should be 623.5€
     */
    public function weeklyIncomeShouldBeEu()
    {
        throw new PendingException();
    }

    /**
     * @Then Total tickets sold should be :arg1
     */
    public function totalTicketsSoldShouldBe($arg1)
    {
        throw new PendingException();
    }
}
