<?php

namespace Tests\Library\Mapper;
use Library\Mapper\Mappable;
use Library\Mapper\SimpleMapper;

class SimpleMapperTest extends \PHPUnit_Framework_Testcase {
	
	public function test_it_maps_simple_dto()
	{
		$expectedDto = new Utils\SimpleDTO();
		$expectedDto->setId(1);
		$expectedDto->setTitle('Title');
		$expectedDto->setContent('Content');

		$map = array(
			'simplemodel.id' => 1,
			'simplemodel.title' => 'Title',
			'simplemodel.content' => 'Content'
		);

		$descriptor = $this
			->getMockBuilder('Library\Mapper\Descriptor\ObjectDescriptor')
			->disableOriginalConstructor()
			->getMock();
		
		$descriptor->expects($this->once())
			 ->method('describe')
			 ->will($this->returnValue($map));
		
		$Mapper = new SimpleMapper($descriptor);


		$dto = $Mapper->map(
			new Utils\SimpleModel(1, 'Title', 'Content'), 
			new Utils\SimpleDTO()
		);
		
		$this->assertEquals($expectedDto, $dto);
	}
}
?>