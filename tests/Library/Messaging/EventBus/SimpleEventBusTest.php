<?php

namespace Tests\Library\Messaging\EventBus;

use Milhojas\Library\Messaging\EventBus\EventBus;
use Milhojas\Library\Messaging\EventBus\Event;
use Tests\Library\Messaging\EventBus\Utils\EventBusSpy;
use Tests\Library\Messaging\EventBus\Fixtures\TestEvent;
use Tests\Library\Messaging\EventBus\Fixtures\IgnoredEvent;
use Tests\Library\Messaging\EventBus\Fixtures\SimpleEvent;
use Tests\Library\Messaging\EventBus\Fixtures\TestListener;
use Tests\Library\Messaging\EventBus\Fixtures\SimpleListener;
use Tests\Utils\DummyLogger;

/**
 * Description.
 */
class EventBusTest extends \PHPUnit_Framework_Testcase
{
    private function getEventBus()
    {
        return new EventBus(new DummyLogger('Test'));
    }

    public function test_it_can_add_Event_Handlers()
    {
        $bus = new EventBusSpy($this->getEventBus());
        $bus->addListener('test.event', new TestListener($bus));
        $this->assertTrue($bus->assertWasRegistered('test.event', new TestListener($bus)));
    }

    public function test_it_can_handle_an_event_to_handlers()
    {
        $bus = new EventBusSpy($this->getEventBus());
        $bus->addListener('test.event', new TestListener($bus));
        $bus->dispatch(new TestEvent('data'));
        $expected = array(
            'test.event' => array('TestListener'),
        );

        $this->assertEquals($expected, $bus->getRecordedHandlers());
    }

    public function test_it_silently_ignore_events_not_registered()
    {
        $bus = new EventBusSpy($this->getEventBus());
        $bus->addListener('test.event', new TestListener($bus));
        $bus->dispatch(new IgnoredEvent('data'));
        $this->assertFalse($bus->eventWasHandled('ignored.event'));
    }

    public function test_it_does_not_handle_events_not_passed()
    {
        $bus = new EventBusSpy($this->getEventBus());
        $bus->addListener('test.event', new TestListener($bus));
        $bus->dispatch(new TestEvent('data'));
        $this->assertFalse($bus->eventWasHandled('ignored.event'));
        $this->assertTrue($bus->eventWasHandled('test.event'));
    }

    public function test_it_handles_several_events_with_different_handlers()
    {
        $bus = new EventBusSpy($this->getEventBus());
        $bus->addListener('test.event', new TestListener($bus));
        $bus->addListener('simple.event', new SimpleListener($bus));
        $bus->dispatch(new TestEvent('data'));
        $bus->dispatch(new SimpleEvent('other Data'));
        $expected = array(
            'test.event' => array('TestListener'),
            'simple.event' => array('SimpleListener'),
        );
        $this->assertEquals($expected, $bus->getRecordedHandlers());
    }

    public function test_it_handles_several_events_with_same_handler()
    {
        $bus = new EventBusSpy($this->getEventBus());
        $bus->addListener('test.event', new TestListener($bus));
        $bus->addListener('simple.event', new TestListener($bus));
        $bus->dispatch(new TestEvent('data'));
        $bus->dispatch(new SimpleEvent('other Data'));
        $expected = array(
            'test.event' => array('TestListener'),
            'simple.event' => array('TestListener'),
        );
        $this->assertEquals($expected, $bus->getRecordedHandlers());
    }

    public function test_a_handler_can_subscribe_to_several_events()
    {
        $bus = new EventBusSpy($this->getEventBus());
        // $bus->addListener('test.event', new TestListener($bus));
        // $bus->addListener('simple.event', new TestListener($bus));
        $bus->subscribeListener(new TestListener($bus), ['test.event', 'simple.event']);
        $bus->dispatch(new TestEvent('data'));
        $bus->dispatch(new SimpleEvent('other Data'));
        $expected = array(
            'test.event' => array('TestListener'),
            'simple.event' => array('TestListener'),
        );
        $this->assertEquals($expected, $bus->getRecordedHandlers());
    }
}
