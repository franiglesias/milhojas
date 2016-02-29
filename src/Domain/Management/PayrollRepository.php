<?php

namespace Milhojas\Domain\Management;

/**
 * Repository/factory for payroll. It returns a Payroll object with all needed settings made
 * 
 * @package AppBundle.command.payroll
 * @author Francisco Iglesias Gómez
 */
interface PayrollRepository {
	public function get($payrollFile);
	// Returns a finder
	public function finder();
	// Iterate the files for a month
	public function getFiles($month);
}



?>