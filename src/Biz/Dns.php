<?php

namespace Fiber\Biz;

use Fiber\Helper as f;

class Dns
{
    function dig($name = 'fiberphp.org')
    {
        return f\dig($name);
    }
}
