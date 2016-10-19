<?php

namespace Milhojas\Domain\Management;

use Milhojas\Library\ValueObjects\Identity\Username;

/**
 * Represents a list of employees in Management Bounded Context
 *
 * @package management.milhojas
 * @author Fran Iglesias
 */

interface Staff {
	public function getEmployeeByUsername(Username $username);
}

?>
