<?php
/**
 * Created by PhpStorm.
 * User: miralba
 * Date: 24/3/17
 * Time: 11:32
 */

namespace Tests\Domain\Management;

use Milhojas\Domain\Management\PayrollDocument;
use PHPUnit\Framework\TestCase;


class PayrollDocumentTest extends TestCase
{

    public function test_it_returns_the_path_to_the_document()
    {
        $file = $this->prophesize(\SplFileInfo::class);
        $file->getRealPath()->willReturn('/inbox/document.pdf');
        $document = new PayrollDocument($file->reveal());
        $this->assertEquals('/inbox/document.pdf', $document->getPath());
    }

    public function test_it_returns_the_path_to_the_document_even_if_realpath_is_not_available_for_some_reason()
    {
        $file = $this->prophesize(\SplFileInfo::class);
        $file->getRealPath()->willReturn(false);
        $file->getPathname()->willReturn('/inbox/document.pdf');
        $document = new PayrollDocument($file->reveal());
        $this->assertEquals('/inbox/document.pdf', $document->getPath());
    }
}
