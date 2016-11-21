<?php

namespace Milhojas\Domain\Utils;

interface Schedule
{
    public function isScheduledDate(\DateTime $date);
    public function update(Schedule $delta);
}
