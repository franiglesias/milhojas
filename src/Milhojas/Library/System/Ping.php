<?php

namespace Milhojas\Library\System;

class Ping {
	public static function check($host)
	{
		exec(sprintf('ping -c 1 -W 5 %s', escapeshellarg($host)), $res, $rval);
		return $rval === 0;
	}
	
	public static function isListening($host, $port=80, $timeout=6)
	{
        if (! @fsockopen($host, $port, $errno, $errstr, $timeout) )
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
	}
}

?>
