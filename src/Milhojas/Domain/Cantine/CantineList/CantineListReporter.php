<?php

namespace Milhojas\Domain\Cantine\CantineList;

abstract class CantineListReporter
{
    abstract public function visitRecord(CantineListUserRecord $cantineListUserRecord);
}
