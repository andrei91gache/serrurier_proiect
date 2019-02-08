<?php

namespace BackOfficeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BackOfficeBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
