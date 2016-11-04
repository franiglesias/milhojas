<?php

namespace Milhojas\Library\ValueObjects\Technical {

    function exec($command, &$output = '', &$return = '')
    {
        list($c, $opt, $ip) = explode(' ', $command);
        switch ($ip) {
            case '172.16.0.1':
            $output = '? (172.16.0.1) at c4:2c:3:2:ff:b7 on en0 ifscope [ethernet]';
            break;
            case '172.16.0.43':
            $output = '172.16.0.2 (172.16.0.2) -- no entry';
            break;
            default:
            $output = sprintf('? (%s) at at c4:2c:03:02:ff:b7 on en0 ifscope [ethernet]', $ip);
            break;
        }
        $return = 0;
        return $output;
    }
}

 ?>
