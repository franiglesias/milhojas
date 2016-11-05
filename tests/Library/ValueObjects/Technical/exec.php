<?php

namespace Milhojas\Library\ValueObjects\Technical;

/**
 * Mocks native exec function
 *
 * Undocumented function long description
 *
 * @param type var Description
 * @return return type
 */

function exec($command, &$output = '', &$return = '')
{
    $parts = explode(' ', $command);
    switch ($parts[0]) {
      case 'arp':
        return exec_arp($command, $output, $return);
        break;
      case 'ping':
        return exec_ping($command, $output, $return);
        break;
      default:
        # code...
        break;
    }
}

function exec_arp($command, &$output = '', &$return = '')
{
  list($c, $opt, $ip) = explode(' ', $command);
  switch ($ip) {
      case '172.16.0.1':
      $output = '? (172.16.0.1) at c4:2c:3:2:ff:b7 on en0 ifscope [ethernet]';
      break;
      case '172.16.0.2':
      $output = '172.16.0. (172.16.0.2) -- no entry';
      break;
      default:
      $output = sprintf('? (%s) at at c4:2c:03:02:ff:b7 on en0 ifscope [ethernet]', $ip);
      break;
  }
  $return = 0;
  return $output;
}

function exec_ping($command, &$output, &$return)
{
  $parts = explode(' ', $command);
  $ip = trim(array_pop($parts), '\'');
  switch ($ip) {
    case '127.0.0.1':
      $output = '';
      $return = 0;
    break;
    default:
      $output = '';
      $return = 1;
      break;
  }
  return $return;
}

 ?>
