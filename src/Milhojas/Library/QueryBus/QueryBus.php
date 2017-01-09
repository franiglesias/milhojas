<?php

namespace Milhojas\Library\QueryBus;

interface QueryBus
{
    public function execute(Query $query);
}
