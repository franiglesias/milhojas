<?php

namespace Milhojas\Domain\Cantine;

interface CantineUser {
    public function isEatingOnDate(\DateTime $date);
}
 ?>
