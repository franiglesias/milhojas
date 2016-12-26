<?php

namespace Milhojas\Domain\Cantine\CantineList;

class SpecialMealsCantineListReporter
{
    private $report;

    public function visit(CantineListUserRecord $cantineListUserRecord)
    {
        if ($cantineListUserRecord->getRemarks()) {
            $line['remarks'] = $cantineListUserRecord->getRemarks();
            $line['user'] = $cantineListUserRecord->getUserListName();
            $line['turn'] = $cantineListUserRecord->getTurnName();
            $this->report[] = $line;
        }
    }

    public function getReport()
    {
        return $this->report;
    }
}
