<?php

namespace Domain\Contents;

interface PostRepositoryInterface {
	public function get(PostId $id);
	public function save(Post $Post);
	public function findSatisfying(\Library\Specification\AbstractSpecification $Specification);
}
?>