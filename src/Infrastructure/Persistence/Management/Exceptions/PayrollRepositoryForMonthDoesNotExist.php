<?php

namespace Milhojas\Infrastructure\Persistence\Management\Exceptions;

use Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryException;

/**
 * Represents the condition in which Payroll Repository for a month can not be found
 *
 * @package default
 * @author Fran Iglesias
 */

class PayrollRepositoryForMonthDoesNotExist extends PayrollRepositoryException {}

?>
