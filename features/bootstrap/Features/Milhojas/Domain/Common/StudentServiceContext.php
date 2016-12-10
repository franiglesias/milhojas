<?php

namespace Features\Milhojas\Domain\Common;

use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Context;
use Milhojas\Domain\Common\Student;
use Milhojas\Domain\Common\Specification\StudentNamed;
use Milhojas\Domain\Common\StudentId;
use Milhojas\Infrastructure\Persistence\Common\StudentServiceInMemoryRepository;
use Milhojas\LIbrary\ValueObjects\Identity\Person;

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
        $student_id = new StudentId($student_id);
        $student_name = new Person($name, $surname, '');
        $this->StudentRepository->store(new Student($student_id, $student_name, $class, ''));
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
        $student_id = new StudentId($data['studentId']);
        $student_name = new Person($data['name'], $data['surname'], '');
        $expected = new Student($student_id, $student_name, $data['class'], '');
        if ($expected != $this->student) {
            throw new \Exception('Student data is not as expected.');
        }
    }
}
