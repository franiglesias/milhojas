<?php

namespace spec\Milhojas\Domain\Cantine\Factories;

use Milhojas\Domain\Cantine\Factories\AllergensFactory;
use Milhojas\Domain\Cantine\Allergens;
use PhpSpec\ObjectBehavior;

class AllergensFactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(AllergensFactory::class);
    }

    public function it_creates_blank_allergens_checklists()
    {
        $this->configure(['almonds', 'gluten', 'fish', 'eggs', 'seafood']);
        $this->getBlankAllergensSheet()->shouldHaveType(Allergens::class);
    }
}
