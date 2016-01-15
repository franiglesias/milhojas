<?php

namespace Domain\Contents;

interface PostRepositoryInterface {
	public function get(PostId $id);
	public function save(Post $Post);
}
?>