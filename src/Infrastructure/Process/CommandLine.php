<?php

namespace Milhojas\Infrastructure\Process;

interface CommandLine {
	public function setWorkingDirectory($directory);
	public function start(callable $callable = null);
}

?>
