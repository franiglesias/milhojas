<?php

namespace Milhojas\Domain\Cantine\CantineList;

/**
 * Visitor to generate Special Meal reports from a CantineList.
 */
class SpecialMealsCantineSeatListReporter extends CantineSeatListReporter
{
    private $report;

    /**
     * Generate a entry for the report.
     *
     * @param CantineSeat $cantineListUserRecord
     */
    public function visitRecord(CantineSeat $seat)
    {
        if ($seat->getRemarks()) {
            $this->report[] = new SpecialMealsRecord(
                $seat->getTurnName(),
                $seat->getUserListName(),
                $seat->getRemarks()
            );
        }
    }

    public function getReport()
    {
        return $this->report;
    }
}
