<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Milhojas\Domain\Cantine\CantineRule;
use Milhojas\Domain\Cantine\RegularCantineUser;
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
     * @Given there is a CantineRule that applies on weekday :arg1 to CantineGroup :arg2
     */
    public function thereIsACantineruleThatAppliesOnWeekdayToCantinegroup($arg1, $arg2)
    {
        $this->rule = new CantineRule([$arg1], [$arg2]);
    }


    /**
     * @When I ask for Turn on :arg1
     */
    public function iAskForTurnOn($arg1)
    {
        $this->rule->getAssignedTurn($this->regularUser, $arg1);
    }

    /**
     * @Then I should Get :arg1 as the Turn
     */
    public function iShouldGetAsTheTurn($arg1)
    {
        $turn = $this->rule->getAssignedTurn($this->regularUser, '11/14/2016');
        if ($turn != '1') {
            throw new Exception(sprintf('Got %s and expecting %s', $turn, $arg1));

        }
    }

    /**
     * @Given there is a RegularCantineUser that has StudentId :arg1 that eats on :arg2 and belongs to CantineGroup :arg3
     */
    public function thereIsARegularcantineuserThatHasStudentidThatEatsOnAndBelongsToCantinegroup($arg1, $arg2, $arg3)
    {
        $this->regularUser = new RegularCantineUser($arg1, $arg2, $arg3);
    }
}
