<?php

namespace Milhojas\Domain\Management;

/**
 * Repository/factory for payroll. It returns a Payroll object with all needed settings made
 * 
 * @package AppBundle.command.payroll
 * @author Francisco Iglesias Gómez
 */
interface PayrollRepository {
	public function get($file);
}



?>