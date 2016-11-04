<?php

namespace Milhojas\Domain\It;

use Milhojas\Library\ValueObjects\Technical\Ip;
use Milhojas\Library\ValueObjects\Technical\Mac;

/**
 * Represents a Device managed by this application
 */
class Device
{
    private $name;
    private $ip;
    private $mac;

    public function __construct($name, Ip $ip, Mac $mac)
    {
        $this->name = $name;
        $this->ip = $ip;
        $this->mac = $mac;
    }


}


 ?>
