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
    public function visitRecord(CantineSeat $cantineListUserRecord)
    {
        if ($cantineListUserRecord->getRemarks()) {
            $this->report[] = new SpecialMealsRecord(
                $cantineListUserRecord->getTurnName(),
                $cantineListUserRecord->getUserListName(),
                $cantineListUserRecord->getRemarks()
            );
        }
    }

    public function getReport()
    {
        return $this->report;
    }
}
