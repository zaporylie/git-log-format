<?php

namespace Violinist\GitLogFormat\Test;

use Violinist\GitLogFormat\ChangeLogData;

class DummyChangeLog extends ChangeLogData
{
    protected function gitSourceIsSupported($git)
    {
        return true;
    }
}
