<?php

namespace Features\Milhojas\Domain\Cantine;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class BillingContext implements Context
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
     * @Given There are some regular users
     */
    public function thereAreSomeRegularUsers(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given prices are the following
     */
    public function pricesAreTheFollowing(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @When I generate bills for month :arg1
     */
    public function iGenerateBillsForMonth($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should get a list of users like this
     */
    public function iShouldGetAListOfUsersLikeThis(TableNode $table)
    {
        throw new PendingException();
    }
}
