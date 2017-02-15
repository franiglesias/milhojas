<?php

namespace Milhojas\Domain\Cantine;

use Milhojas\Library\Collections\Checklist;

class Allergens
{
    public function __construct(Checklist $checklist)
    {
        $this->list = $checklist;
    }

    public function check($allergens)
    {
        $this->list->check($allergens);
    }

    public function isAllergic()
    {
        return $this->list->hasMarks() > 0;
    }

    public function hasCoincidencesWith(Allergens $another)
    {
        return $this->list->hasCoincidencesWith($another->list);
    }

    public function getAsString()
    {
        return $this->list->getListAsString();
    }
}
