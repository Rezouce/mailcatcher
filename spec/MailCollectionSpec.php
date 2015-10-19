<?php

namespace spec\MailCatcher;

use MailCatcher\MailCatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailCollectionSpec extends ObjectBehavior
{

    function let(MailCatcher $mailCatcher)
    {
        $this->beConstructedWith($mailCatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MailCatcher\MailCollection');
    }
}
