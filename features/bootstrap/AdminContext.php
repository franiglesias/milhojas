<?php

use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Defines application features from the specific context.
 */
class AdminContext implements SnippetAcceptingContext
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
}
