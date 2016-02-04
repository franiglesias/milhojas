<?php

namespace Tests\Domain\Contents;

use Milhojas\Domain\Contents\PostDTOAssembler;

use Milhojas\Domain\Contents\DTO\PostDTO;

/**
* Description
*/
class PostDTOAssemblerTest extends \PHPUnit_Framework_Testcase
{

	private function getPostDTO()
	{
		$dto = new PostDTO();
		$dto->setId(1);
		$dto->getContent()->setTitle('Title');
		$dto->getContent()->setBody('Body');
		$dto->setPubDate('2016-01-01');
		$dto->setExpiration(null);
		$dto->setState('PublishedPostState');
		return $dto;
	}
	
	public function test_it_maps_a_Post_object()
	{
		$PostDTO = $this->getPostDTO();
		
		$map = array(
			'post.id.id' => 1,
			'post.content.title' => 'Title',
			'post.content.body' => 'Body',
			'post.publication.start.date' => '2016-01-01',
			'post.state' => 'PublishedPostState'
		);

		$Assembler = new PostDTOAssembler();
		$dto = $Assembler->assemble($map);
		$this->assertEquals($dto, $PostDTO);
	}

}
?>