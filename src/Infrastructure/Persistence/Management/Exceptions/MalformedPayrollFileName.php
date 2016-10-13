<?php

namespace Milhojas\Infrastructure\Persistence\Management\Exceptions;

/**
 * Represents the condition in which a payroll file name doesn't contain a recognizable employee id or name
 *
 * @package default
 * @author Fran Iglesias
 */

class MalformedPayrollFileName extends \UnexpectedValueException {}

?>
