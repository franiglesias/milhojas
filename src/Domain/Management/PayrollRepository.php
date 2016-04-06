<?php

namespace Milhojas\Domain\Management;

/**
 * Repository/factory for payroll. It returns a Payroll object with all needed settings made and manages payroll
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