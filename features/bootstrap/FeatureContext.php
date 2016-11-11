<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

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
     * @Given there is a :arg1 EducationStage
     */
    public function thereIsAEducationstage($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given there is a :arg1 EducationLevel
     */
    public function thereIsAEducationlevel($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given there is a :arg1 Subject
     */
    public function thereIsASubject($arg1)
    {
        throw new PendingException();
    }

    /**
     * @When I create a new Course
     */
    public function iCreateANewCourse()
    {
        throw new PendingException();
    }

    /**
     * @Then I should have a new Course
     */
    public function iShouldHaveANewCourse()
    {
        throw new PendingException();
    }

    /**
     * @Then the name of the Course should be :arg1
     */
    public function theNameOfTheCourseShouldBe($arg1)
    {
        throw new PendingException();
    }
}
