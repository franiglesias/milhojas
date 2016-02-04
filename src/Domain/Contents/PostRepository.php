<?php

namespace Milhojas\Domain\Contents;

interface PostRepository {
	public function get(PostId $id);
	public function save(Post $Post);
	public function findSatisfying(\Milhojas\Library\Specification\Specification $Specification);
}
?>