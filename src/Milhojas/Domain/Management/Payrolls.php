<?php

namespace Milhojas\Domain\Management;


/**
 * Represent a repository for payroll files. It could be the FileSystem or a zip file
 *
 * @author Fran Iglesias
 */
interface Payrolls
{
    public function getForEmployee(Employee $employee, PayrollMonth $month);
    public function getAttachments(Employee $employee, PayrollMonth $month);
    public function archive(Employee $employee, PayrollMonth $month);

    public function getFilesNotSent(PayrollMonth $monh);
    public function loadMonthDataFrom(PayrollMonth $month, array $path);
}

?>
