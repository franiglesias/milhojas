<?php

namespace Milhojas\Domain\Cantine\CantineList;

/**
 * Visitor to generate Special Meal reports from a CantineList.
 */
class SpecialMealsCantineListReporter extends CantineListReporter
{
    private $report;

    /**
     * Generate a entry for the report.
     *
     * @param CantineListUserRecord $cantineListUserRecord
     */
    public function visitRecord(CantineListUserRecord $cantineListUserRecord)
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