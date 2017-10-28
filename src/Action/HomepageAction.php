<?php

namespace App\Action;

use App\Greeter;
use Zend\Diactoros\Response\TextResponse;

class HomepageAction
{
    /**
     * @var Greeter
     */
    private $greeter;

    /**
     * Constructor
     *
     * @param Greeter $greeter
     */
    public function __construct(Greeter $greeter)
    {
        $this->greeter = $greeter;
    }

    public function __invoke()
    {
        return new TextResponse(call_user_func($this->greeter, 'World'));
    }
}
