<?php

namespace Milhojas\Domain\Cantine\CantineList;

use Milhojas\Domain\Cantine\CantineList\CantineListUserRecord;
use Milhojas\Domain\Cantine\CantineList\CantineList;
abstract class CantineListReporter
{
    abstract public function visitRecord(CantineListUserRecord $cantineListUserRecord);

    public function visitCantineList(CantineList $cantineList)
    {
        foreach ($cantineList as $record) {
            $record->accept($this);
        }
    }
}
