<?php

namespace Tests\Library\EventBus;

use Milhojas\Library\EventBus\EventRecorder;

use Milhojas\Library\EventBus\Event;
use Tests\Library\EventBus\Fixtures\SimpleEvent;

/**
* Description
*/
class EventRecorderTest extends \PHPUnit_Framework_Testcase
{
	
	function test_it_can_record_an_event()
	{
		$recorder = new EventRecorder();
		$recorder->recordThat(new SimpleEvent('data'));
		$this->assertEquals(1, iterator_count($recorder));
	}
	
	function test_it_can_record_more_than_one_event()
	{
		$recorder = new EventRecorder();
		$recorder->recordThat(new SimpleEvent('1'));
		$recorder->recordThat(new SimpleEvent('2'));
		$recorder->recordThat(new SimpleEvent('3'));
		$this->assertEquals(3, iterator_count($recorder));
	}
	
	
	public function test_it_can_return_stored_events()
	{
		$recorder = new EventRecorder();
		$recorder->recordThat(new SimpleEvent('1'));
		$recorder->recordThat(new SimpleEvent('2'));
		$recorder->recordThat(new SimpleEvent('3'));
		$this->assertEquals(3, count($recorder->retrieve()));

	}
	
	public function test_it_can_record_several_events_in_batch()
	{
		$events = array(
			new SimpleEvent('1'),
			new SimpleEvent('2'),
			new SimpleEvent('3')
		);
		$recorder = new EventRecorder();
		$recorder->load($events);
		$this->assertEquals(3, count($recorder->retrieve()));

	}
	
	public function test_it_can_return_stored_events_in_the_same_order()
	{
		$recorder = new EventRecorder();
		$recorder->recordThat(new SimpleEvent('1'));
		$recorder->recordThat(new SimpleEvent('2'));
		$recorder->recordThat(new SimpleEvent('3'));
		$counter = 1;
		foreach ($recorder->retrieve() as $event) {
			$this->assertEquals($counter, $event->getData());
			$counter++;
		}
	}
	
	public function test_it_can_forget_events()
	{
		$recorder = new EventRecorder();
		$recorder->recordThat(new SimpleEvent('1'));
		$recorder->recordThat(new SimpleEvent('2'));
		$recorder->recordThat(new SimpleEvent('3'));
		$recorder->flush();
		$this->assertEquals(0, iterator_count($recorder));
	}
	
	
}


?>