<?php

namespace Features\Milhojas\Domain\Shared;

use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Context;
use Milhojas\Domain\Shared\Student;
use Milhojas\Domain\Shared\Specification\StudentNamed;
use Milhojas\Domain\Shared\StudentId;
use Milhojas\Domain\Shared\Specification\StudentsWhoseNameContains;
use Milhojas\Infrastructure\Persistence\Shared\StudentServiceInMemoryRepository;
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
     * @Given There is a Student with id :student_id and name :student_name and gender :gender that is in class :class
     */
    public function thereIsAStudentWithIdAndNameAndGenderThatIsInClass($student_id, $student_name, $gender, $class)
    {
        list($name, $surname) = explode(' ', $student_name);
        $student_id = new StudentId($student_id);
        $student_name = new Person($name, $surname, $gender[0]);
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
        $expected = $this->castRowToStudent($table->getRowsHash());
        if ($expected != $this->student) {
            throw new \Exception('Student data is not as expected.');
        }
    }

    public function castRowToStudent($row)
    {
        $student_id = new StudentId($row['studentId']);
        $student_name = new Person($row['name'], $row['surname'], $row['gender']);

        return new Student($student_id, $student_name, $row['class'], '');
    }
    /**
     * @Given There are several Students in the repository
     */
    public function thereAreSeveralStudentsInTheRepository(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $this->StudentRepository->store($this->castRowToStudent($row));
        }
    }

    /**
     * @When I ask for a student whose name contains :fragment
     */
    public function iAskForAStudentWhoseNameContains($fragment)
    {
        $students = $this->StudentRepository->find(new StudentsWhoseNameContains($fragment));
        $this->autocomplete = [];
        foreach ($students as $student) {
            $this->autocomplete[$student->getId()->getId()] = $student->getLabel();
        }
    }

    /**
     * @Then I should get a list of users that match
     */
    public function iShouldGetAListOfUsersThatMatch(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $expected[$row['studentId']] = $row['student_label'];
        }
        if ($this->autocomplete != $expected) {
            throw new \Exception('Failed autocomplete');
        }
    }
}
