<?php

namespace spec\MailCatcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('MailCatcher\MailCollection');
    }
}
