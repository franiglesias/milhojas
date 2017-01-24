<?php

namespace spec\Milhojas\Application\Management;

use League\Flysystem\FilesystemInterface;
use Milhojas\Application\Management\PayrollProgressExchange;
use Milhojas\Domain\Management\PayrollReporter;
use PhpSpec\ObjectBehavior;

class PayrollProgressExchangeSpec extends ObjectBehavior
{
    public function let(FilesystemInterface $fs)
    {
        $this->beConstructedWith('exchange-file.json', $fs);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(PayrollProgressExchange::class);
    }

    public function it_inits_exchange_file_creating_a_new_empty_one($fs)
    {
        $fs->put('exchange-file.json', '')->shouldBeCalled();
        $this->init();
    }

    public function it_reads_current_contents_of_echange_file($fs)
    {
        $fs->has('exchange-file.json')->shouldBeCalled()->willReturn(true);
        $fs->read('exchange-file.json')->shouldBeCalled()->willReturn('contents');
        $this->read()->shouldBe('contents');
    }

    public function it_gives_default_content_if_no_file($fs)
    {
        $fs->has('exchange-file.json')->shouldBeCalled()->willReturn(false);
        $this->read()->shouldBe('');
    }

    public function it_resets_file($fs)
    {
        $fs->has('exchange-file.json')->shouldBeCalled()->willReturn(true);
        $fs->delete('exchange-file.json')->shouldBeCalled();
        $this->reset();
    }

    public function it_updates(PayrollReporter $reporter, $fs)
    {
        $reporter->asJson()->willReturn('data');
        $fs->has('exchange-file.json')->shouldBeCalled()->willReturn(true);
        $fs->put('exchange-file.json', 'data')->shouldBeCalled();
        $this->update($reporter);
    }
}
