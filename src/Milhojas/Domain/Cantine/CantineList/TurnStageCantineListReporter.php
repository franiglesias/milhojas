<?php

namespace Milhojas\Domain\Cantine\CantineList;

class TurnStageCantineListReporter extends CantineListReporter
{
    private $counters;
    private $totals;
    /**
     * Reset counters
     */
    public function __construct()
    {
        $this->counters = [];
        $this->totals = [];
    }

    /**
     * @param CantineListUserRecord $cantineListUserRecord
     */
    public function visitRecord(CantineListUserRecord $cantineListUserRecord)
    {
        $turn = $cantineListUserRecord->getTurnName();
        $stage = $cantineListUserRecord->getStageName();
        $this->initCounters($turn, $stage);
        ++$this->counters[$turn][$stage];
        ++$this->counters[$turn]['total'];
        ++$this->totals['all'];
        ++$this->totals[$stage];
    }

    /**
     * Get the counters
     * @return array
     */
    public function getReport()
    {
        return $this->counters;
    }

    /**
     * Get totals
     * @return array
     */
    public function getTotal()
    {
        return $this->totals;
    }

    /**
     * Starts the counters
     * @param mixed $turn
     * @param mixed $stage
     */
    private function initCounters($turn, $stage)
    {
        if (!isset($this->counters[$turn])) {
            $this->counters[$turn]['total'] = 0;
        }
        if (!isset($this->counters[$turn][$stage])) {
            $this->counters[$turn][$stage] = 0;
        }
        if (!isset($this->totals['all'])) {
            $this->totals['all'] = 0;
        }
        if (!isset($this->totals[$stage])) {
            $this->totals[$stage] = 0;
        }
    }
}
