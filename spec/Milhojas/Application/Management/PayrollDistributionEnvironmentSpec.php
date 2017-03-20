<?php

namespace spec\Milhojas\Application\Management;

use Milhojas\Application\Management\PayrollDistributionEnvironment;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class PayrollDistributionEnvironmentSpec extends ObjectBehavior
{
    public function let(\AppKernel $kernel)
    {
        $kernel->getEnvironment()->shouldBeCalled()->willReturn('dev');
        $kernel->getRootDir()->shouldBeCalled()->willReturn('/path/to/dir');
        $kernel->getLogDir()->shouldBeCalled()->willReturn('/path/to/logs');

        $this->beConstructedThrough('fromSymfonyKernel', [$kernel, 'mylog.log']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PayrollDistributionEnvironment::class);
    }

    public function it_returns_the_environment($kernel)
    {
        $this->getEnvironment()->shouldBe('dev');
    }

    public function it_returns_the_root_dir($kernel)
    {
        $this->getRootPath()->shouldBe('/path/to/dir/../');
    }

    public function it_returns_the_log_file($kernel)
    {
        $this->getLogfile()->shouldBe('/path/to/logs/mylog.log');
    }
}
