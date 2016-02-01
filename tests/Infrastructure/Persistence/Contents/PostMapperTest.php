<?php

namespace Tests\Infrastructure\Persistence\Contents;

use Domain\Contents\PostAssembler;
use Library\Mapper\SimpleMapper;
use Library\Mapper\Descriptor\ObjectDescriptor;
use Library\Mapper\Descriptor\PropertyDescriptor;
/**
* Description
*/
class PostAssemblerTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_maps_a_Post_object()
	{
		$Post = $this->getMockBuilder('\Domain\Contents\Post')
			->disableOriginalConstructor()
				->getMock();
		$PostDTO = $this->getMock('\Domain\Contents\DTO\PostDTO');
		$Mapper = $this->getMockBuilder('\Library\Mapper\SimpleMapper')
			->disableOriginalConstructor()
				->getMock();
		$Mapper->expects($this->once())
			->method('map')
				->with($this->equalTo($Post), $this->equalTo($PostDTO))
				->will($this->returnValue($PostDTO));
		$PostAssembler = new PostAssembler($Mapper);
		$dto = $PostAssembler->map($Post, $PostDTO);
		$this->assertEquals($dto, $PostDTO);
	}
}
?>