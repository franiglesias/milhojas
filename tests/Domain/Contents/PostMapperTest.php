<?php

namespace Tests\Domain\Contents;

use Domain\Contents\Post;
use Domain\Contents\PostId;
use Domain\Contents\PostContent;

use Domain\Contents\DTO\PostDTO;
use Domain\Contents\DTO\PostContentDTO;
/**
* Description
*/
class PostMapper
{
	private $Post;
	
	function __construct(\Domain\Contents\Post $Post)
	{
		$this->Post = $Post;
	}
	
	public function toDto($dto)
	{
		$mapper = new PostDTOMapper($this, $dto);
		return $mapper->map();
	}
	
	public function getDescription()
	{
		$descriptor = new ObjectDescriptor($this->Post);
		return $descriptor->describe();
	}
}

class ObjectDescriptor {
	
	private $object;
	private $description;
	
	public function __construct($object)
	{
		$this->object = $object;
	}
	public function describe($prefix = null)
	{
		$this->description = array();
		$reflect = new \ReflectionObject($this->object);
		$properties = $reflect->getProperties();
		foreach ($properties as $property) {
			$descriptor = PropertyDescriptor::get($property, $this->object);
			$this->description += $descriptor->describe($reflect->getShortName());
		}
		return $this->description;
	}

}

/**
* Factory of Specialized Property Descriptors
*/
class PropertyDescriptor
{
	static function get(\ReflectionProperty $property, $object)
	{
		$property->setAccessible(true);
		if (!is_object($property->getValue($object))) {
			return new PlainPropertyDescriptor($property, $object);
		}
		if (self::hasProperties($property->getValue($object))) {
			return new ObjectPropertyDescriptor($property, $object);
		}
		return new EmptyPropertyDescriptor($property, $property->getValue($object));
	}
	
	static private function hasProperties($object)
	{
		return (new \ReflectionObject($object))->getProperties();
	}
}

/**
* Description
*/
class PlainPropertyDescriptor
{
	protected $property;
	protected $object;
	
	function __construct(\ReflectionProperty $property, $object)
	{
		$this->property = $property;
		$this->property->setAccessible(true);
		$this->object = $object;
	}
	
	public function describe($prefix = null)
	{
		$value = $this->property->getValue($this->object);
		return array($this->getQualifiedName($prefix) => $value);
	}
	
	protected function getQualifiedName($prefix)
	{
		return strtolower(($prefix ? $prefix.'.' : '').$this->property->getName());
	}
}

/**
* Description
*/
class EmptyPropertyDescriptor extends PlainPropertyDescriptor
{
	public function describe($prefix = null)
	{
		$r = new \ReflectionObject($this->object);
		return array($this->getQualifiedName($prefix) => $r->getShortName());
	}
}

/**
* Description
*/
class ObjectPropertyDescriptor extends PlainPropertyDescriptor
{

	public function describe($prefix = null)
	{
		$object = $this->property->getValue($this->object);
		$description = array();
		foreach ($this->getProperties($object) as $property) {
			$descriptor = PropertyDescriptor::get($property, $object);
			$description += $descriptor->describe($this->getQualifiedName($prefix));
		}
		return $description;
	}
	
	private function getProperties($object)
	{
		return (new \ReflectionObject($object))->getProperties();
	}
}


class MyClass {
	private $id;
	private $name;
	public $comment;
	
	public function __construct($id, $name, $comment)
	{
		$this->id = $id;
		$this->name = $name;
		$this->comment = $comment;
	}
}

/**
* Description
*/
class Complex
{
	private $subclass;
	private $name;
	
	function __construct($name, MyClass $subclass)
	{
		$this->name = $name;
		$this->subclass = $subclass;
	}
}

class ObjectDescriptorTest extends \PHPUnit_Framework_Testcase{
	
	public function test_we_get_simple_property_descriptor()
	{
		$mc = new MyClass(1, 'My Class', 'A Comment');
		$r = new \ReflectionObject($mc);
		$property = $r->getProperty('id');
		$pd = PropertyDescriptor::get($property, $mc);
		$this->assertInstanceOf('Tests\Domain\Contents\PlainPropertyDescriptor', $pd);
		
		
	}
	
	public function test_it_describes_simple_class()
	{
		$mc = new MyClass(1, 'My Class', 'A comment');
		$descriptor = new ObjectDescriptor($mc);
		$description = array(
			'myclass.id' => 1,
			'myclass.name' => 'My Class',
			'myclass.comment' => 'A comment'
		);
		$this->assertEquals($description, $descriptor->describe());
	}

	public function test_it_describes_class_with_members()
	{
		$c = new Complex('Complex', new MyClass(2, 'Simple', 'A member'));
		$descriptor = new ObjectDescriptor($c);
		$description = array(
			'complex.name' => 'Complex',
			'complex.subclass.id' => 2,
			'complex.subclass.name' => 'Simple',
			'complex.subclass.comment' => 'A member'
		);
		$this->assertEquals($description, $descriptor->describe());
	}

	public function test_it_describes_a_complex_object()
	{
		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
		$Post->publish(new \Library\ValueObjects\Dates\DateRange(new \DateTimeImmutable()));
		
		$descriptor = new ObjectDescriptor($Post);
		$description = array(
			'post.id.id' => 1,
			'post.content.title' => 'Title',
			'post.content.body' => 'Body',
			'post.publication.start' => date('Y/m/d'),
			'post.publication.end' => null,
			'post.tags' => null,
			'post.authors' => null,
			'post.attachments' => null
		);
		$this->assertEquals($description, $descriptor->describe());
	}
}

/**
* Description
*/
// class PostMapperTest extends \PHPUNit_Framework_Testcase
// {
// 	public function test_nothing()
// 	{
//
// 	}
// 	public function dont_test_post_mapper_accepts_Post_Entity()
// 	{
// 		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
// 		$mapper = new PostMapper($Post);
// 		$result = $mapper->toDto(new PostDTO());
// 	}
//
// 	public function dont_test_post_mapper_generates_post_description()
// 	{
// 		$Post = Post::write(new PostId(1), new PostContent('Title', 'Body'));
// 		$Post->publish(new \Library\ValueObjects\Dates\DateRange(new \DateTimeImmutable()));
// 		$description = array(
// 			'post.id.id' => 1,
// 			'post.content.title' => 'Title',
// 			'post.content.body' => 'Body',
// 			'post.publication.start' => date('Y/m/d'),
// 			'post.publication.end' => null
// 		);
// 		$mapper = new PostMapper($Post);
// 		$this->assertEquals($description, $mapper->getDescription());
// 	}
// }

?>