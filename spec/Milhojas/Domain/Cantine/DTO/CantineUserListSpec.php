<?php

namespace spec\Milhojas\Domain\Cantine\DTO;

use Milhojas\Domain\Cantine\DTO\CantineUserList;
use PhpSpec\ObjectBehavior;

class CantineUserListSpec extends ObjectBehavior
{
    private $date;
    private $turn = 'Turno 1';
    private $studentId = 'student-01';
    private $name = 'Apellidos, Nombre';
    private $remarks = 'Allergic';

    public function let(\DateTime $date)
    {
        $this->date = new \DateTime();
        $this->beConstructedWith(
            $date,
            'Turno 2',
            'student-02',
            'Perez, Pedro',
            'Sin observaciones'
        );
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(CantineUserList::class);
    }

    public function it_can_set_and_get_date()
    {
        $this->setDate($this->date);
        $this->getDate()->shouldBe($this->date);
    }

    public function it_can_set_and_get_student_id()
    {
        $this->setStudentId($this->studentId);
        $this->getStudentId()->shouldBe($this->studentId);
    }

    public function it_can_set_and_get_turn()
    {
        $this->setTurn($this->turn);
        $this->getTurn()->shouldBe($this->turn);
    }

    public function it_can_set_and_get_name()
    {
        $this->setName($this->name);
        $this->getName()->shouldBe($this->name);
    }

    public function it_can_set_and_get_remarks()
    {
        $this->setRemarks($this->remarks);
        $this->getRemarks()->shouldBe($this->remarks);
    }
}
