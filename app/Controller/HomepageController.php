<?php

namespace App\Controller;

use Zend\Diactoros\Response\TextResponse;

class HomepageController
{
    public function __invoke()
    {
        return new TextResponse('Hello, World!');
    }
}
