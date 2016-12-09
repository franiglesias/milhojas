<?php

namespace Features\Milhojas\Domain\Common;

use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Context;
use Milhojas\Domain\Common\Student;
use Milhojas\Domain\Common\Specification\StudentNamed;
use Milhojas\Infrastructure\Persistence\Common\StudentServiceInMemoryRepository;

/**
 * Defines application features from the specific context.
 */
class StudentServiceContext implements Context
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
        $this->StudentRepository = new StudentServiceInMemoryRepository();
    }

    /**
     * @Given There is a Student with id :student_id and name :student_name that is in class :class
     */
    public function thereIsAStudentWithIdAndNameThatIsInClass($student_id, $student_name, $class)
    {
        list($name, $surname) = explode(' ', $student_name);
        $this->StudentRepository->store(new Student($student_id, $name, $surname, $class, ''));
    }

    /**
     * @When I ask for student named :student_name
     */
    public function iAskForStudentNamed($student_name)
    {
        $this->student = $this->StudentRepository->get(new StudentNamed($student_name));
    }

    /**
     * @Then I should get a StudentDTO object with information
     */
    public function iShouldGetAStudentdtoObjectWithInformation(TableNode $table)
    {
        $data = $table->getRowsHash();
        $expected = new Student($data['studentId'], $data['name'], $data['surname'], $data['class'], '');
        if ($expected != $this->student) {
            throw new \Exception('Student data is not as expected.');
        }
    }
}
