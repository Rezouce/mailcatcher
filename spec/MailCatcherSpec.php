<?php

namespace spec\MailCatcher;

use MailCatcher\MailCatcherAdapter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailCatcherSpec extends ObjectBehavior
{

    /** @var MailCatcherAdapter */
    private $adapter;

    function let(MailCatcherAdapter $adapter)
    {
        $this->adapter = $adapter;

        $this->beConstructedWith($adapter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MailCatcher\MailCatcher');
    }

    function it_should_return_some_messages()
    {
        $this->adapter->messages()->willReturn($this->getMessages());

        $result = $this->messages();

        $result->shouldBeAnInstanceOf('MailCatcher\MailCollection');
        $result->count()->shouldReturn(2);
        $result->first()->subject()->shouldReturn('Subject 1');
    }

    function it_should_remove_messages()
    {
        $this->adapter->removeMessages()->shouldBeCalled();

        $result = $this->removeMessages();
    }

    /**
     * @return array
     */
    private function getMessages()
    {
        return [
            [
                "id" => 1,
                "sender" => "<test@example.com>",
                "recipients" => ["<test@example.com>"],
                "subject" => "Subject 1",
                "size" => "404",
                "created_at" => "2015-10-19T09:40:50.000+00:00",
            ],
            [
                "id" => 2,
                "sender" => "<test@example.com>",
                "recipients" => ["<test@example.com>"],
                "subject" => "Subject 2",
                "size" => "404",
                "created_at" => "2015-10-19T09:40:50.000+00:00",
            ],
        ];
    }
}
