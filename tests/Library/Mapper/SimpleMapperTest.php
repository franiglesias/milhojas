<?php


namespace Tests\Library\Mapper;


/**
* Description
*/
class SimpleModel
{
	private $id;
	private $title;
	private $content;
	
	function __construct($id, $title, $content)
	{
		$this->id = $id;
		$this->title = $title;
		$this->content = $content;
	}
}


/**
* Description
*/
class SimpleDTO
{
	private $id;
	private $title;
	private $content;
	
	function __construct()
	{
		# code...
	}
	
	public function fromMap($map)
	{
		$this->id = $map['simplemodel.id'];
		$this->title = $map['simplemodel.title'];
		$this->content = $map['simplemodel.content'];
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function setContent($content)
	{
		$this->content = $content;
	}
}

/**
* Description
*/
class SimpleMapper
{
	private $descriptor;
	
	function __construct(\Library\Mapper\Descriptor\ObjectDescriptor $descriptor)
	{
		$this->descriptor = $descriptor;
	}
	
	public function map($object, $dto)
	{
		$map = $this->descriptor->describe($object);
		$dto->fromMap($map);
		return $dto;
	}
}

class SimpleMapperTest extends \PHPUnit_Framework_Testcase {
	
	public function test_it_maps_simple_dto()
	{
		$expectedDto = new SimpleDTO();
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
			new SimpleModel(1, 'Title', 'Content'), 
			new SimpleDTO()
		);
		
		$this->assertEquals($expectedDto, $dto);
	}
}
?>