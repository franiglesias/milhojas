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

    public function it_can_be_configured_with_an_array_of_supported_allergens()
    {
        $this->configure(['almonds', 'gluten', 'fish', 'eggs', 'seafood']);
    }

    public function it_creates_blank_allergens_checklists()
    {
        $this->getBlankAllergensSheet()->shouldHaveType(Allergens::class);
    }
}
