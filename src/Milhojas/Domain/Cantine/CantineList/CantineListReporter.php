<?php

namespace Milhojas\Domain\Cantine\CantineList;

use Milhojas\Domain\Cantine\CantineList\CantineListUserRecord;

abstract class CantineListReporter
{
    abstract public function visitRecord(CantineListUserRecord $cantineListUserRecord);
}
