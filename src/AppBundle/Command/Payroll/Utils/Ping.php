<?php

namespace AppBundle\Command\Payroll\Utils;

class Ping {
	static function check($host)
	{
		exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($host)), $res, $rval);
		return $rval === 0;
	}
}

?>