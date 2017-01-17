<?php

namespace Milhojas\Domain\Cantine\CantineList;

abstract class CantineSeatListReporter
{
    abstract public function visitRecord(CantineSeat $cantineListUserRecord);
}
