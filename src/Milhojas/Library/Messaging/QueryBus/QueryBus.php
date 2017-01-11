<?php

namespace Milhojas\Library\Messaging\QueryBus;

interface QueryBus
{
    public function execute(Query $query);
}
