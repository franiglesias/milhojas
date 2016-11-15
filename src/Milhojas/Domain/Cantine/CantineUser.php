<?php

namespace Milhojas\Domain\Cantine;

/**
 * Interface to represent a CantineUser
 *
 */
interface CantineUser {
    public function isEatingOnDate(\DateTime $date);
}
 ?>
