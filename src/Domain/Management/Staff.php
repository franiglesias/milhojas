<?php

namespace Milhojas\Domain\Management;

use Milhojas\Library\ValueObjects\Identity\Username;

/**
 * Represents the list of employees
 *
 * @package default
 * @author Fran Iglesias
 */

interface Staff {
	public function getEmployeeByUsername(Username $username);
}

?>
