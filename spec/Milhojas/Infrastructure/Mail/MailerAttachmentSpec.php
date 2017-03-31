<?php

namespace spec\Milhojas\Infrastructure\Mail;

use Milhojas\Infrastructure\Mail\MailerAttachment;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;


class MailerAttachmentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MailerAttachment::class);
    }

    public function it_can_be_constructed_as_inline()
    {
        $this->beConstructedThrough('inline', ['filename.pdf', 'application/pdf', 'this is the content']);
        $this->getFilename()->shouldBe('filename.pdf');
        $this->getType()->shouldBe('application/pdf');
        $this->getData()->shouldBe('this is the content');
    }

    public function it_can_be_constructed_from_path()
    {
        $file = $this->getFileSystem();
        $this->beConstructedThrough('fromPath', [$file]);
        $this->getFilename()->shouldBe('file.txt');
        $this->getType()->shouldBe('text/plain');
        $this->getPath()->shouldBe('vfs://path/to/file.txt');
        $this->getData()->shouldBe('The new contents of the file');
    }

    private function getFileSystem()
    {
        vfsStream::setup('path', null, ['to' => []]);
        $file = vfsStream::url('path/to/file.txt');

        file_put_contents($file, "The new contents of the file");

        return $file;
    }
}
