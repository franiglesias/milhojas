<?php

namespace Domain\Contents;
use Domain\Contents\Specifications\PostSpecificationInterface;

interface PostRepositoryInterface {
	public function get(PostId $id);
	public function save(Post $Post);
	public function findSatisfying(\Library\Specification\AbstractSpecification $Specification);
}
?>