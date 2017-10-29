<?php

namespace Fiber\Biz;

use Fiber\Helper as f;

class Sleep
{
    public function foo($time_ms = 3000)
    {
        f\sleep($time_ms);

        return time();
    }
}

