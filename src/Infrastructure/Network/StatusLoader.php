<?php

namespace Milhojas\Infrastructure\Network;

interface StatusLoader {
	public function getStatus($force = false);
}

?>