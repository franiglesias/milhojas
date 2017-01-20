<?php

namespace Milhojas\Library\Messaging\Shared\Pipeline;

use Milhojas\Library\Messaging\Shared\Worker\Worker;

/**
 * Acts as Worker Composite, so Pipeline and Workers are equivalent.
 */
interface Pipeline extends Worker
{
}
