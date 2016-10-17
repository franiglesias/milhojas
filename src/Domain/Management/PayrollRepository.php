<?php

namespace Milhojas\Domain\Management;

/**
 * Repository/factory for payroll.
 * 
 * @package AppBundle.command.payroll
 * @author Francisco Iglesias Gómez
 */

interface PayrollRepository {
	public function get($payrollFile);
	// Iterate the files for a month
	public function getFiles($month);
	public function count($month);
}

?>
