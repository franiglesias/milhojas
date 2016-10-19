<?php

namespace Milhojas\Infrastructure\Persistence\Management\Exceptions;

use Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryException;

/**
 * Represents the condition in which Payroll Repository can not be found
 *
 * @package default
 * @author Fran Iglesias
 */

class PayrollRepositoryDoesNotExist extends PayrollRepositoryException {}

?>
