<?php

namespace Tests\Infrastructure\Persistence\Contents;

use Infrastructure\Persistence\Contents\PostMapper;
use Library\Mapper\SimpleMapper;
use Library\Mapper\Descriptor\ObjectDescriptor;
use Library\Mapper\Descriptor\PropertyDescriptor;
/**
* Description
*/
class PostMapperTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_maps_a_Post_object()
	{
		$Post = $this->getMockBuilder('\Domain\Contents\Post')
			->disableOriginalConstructor()
				->getMock();
		$PostDTO = $this->getMock('\Domain\Contents\DTO\PostDTO');
		$map = array();
		$Mapper = $this->getMockBuilder('\Library\Mapper\SimpleMapper')
			->disableOriginalConstructor()
				->getMock();
		$Mapper->expects($this->once())
			->method('map')
				->with($this->equalTo($Post), $this->equalTo($PostDTO))
				->will($this->returnValue($PostDTO));
		$PostMapper = new PostMapper($Mapper);
		$dto = $PostMapper->map($Post, $PostDTO);
		$this->assertEquals($dto, $PostDTO);
	}
}
?>