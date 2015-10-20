<?php

namespace spec\MailCatcher;

use MailCatcher\MailCatcherAdapter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailCollectionSpec extends ObjectBehavior
{

    function let(MailCatcherAdapter $mailCatcher)
    {
        $messages = [
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

        $this->beConstructedWith($mailCatcher, $messages);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MailCatcher\MailCollection');
    }

    function it_should_return_the_number_of_mails()
    {
        $this->count()->shouldReturn(2);
    }

    function it_should_be_traversable()
    {
        $this->shouldBeAnInstanceOf('\IteratorAggregate');
        $this->getIterator()->shouldBeAnInstanceOf('\Traversable');
    }

    function it_should_return_its_first_mail()
    {
        $this->first()->subject()->shouldReturn('Subject 1');
    }

    function it_should_throw_an_exception_when_trying_to_get_the_first_mail_of_an_empty_collection(MailCatcherAdapter $mailCatcher)
    {
        $this->beConstructedWith($mailCatcher, []);

        $this->shouldThrow('MailCatcher\MailCatcherException')->duringFirst();
    }

    function it_should_return_its_last_mail()
    {
        $this->last()->subject()->shouldReturn('Subject 2');
    }

    function it_should_throw_an_exception_when_trying_to_get_the_last_mail_of_an_empty_collection(MailCatcherAdapter $mailCatcher)
    {
        $this->beConstructedWith($mailCatcher, []);

        $this->shouldThrow('MailCatcher\MailCatcherException')->duringLast();
    }

    function it_should_return_its_n_mail()
    {
        $this->get(1)->subject()->shouldReturn('Subject 2');
    }

    function it_should_throw_an_exception_when_trying_to_get_a_mail_not_in_the_collection()
    {
        $this->shouldThrow('MailCatcher\MailCatcherException')->duringGet(2);
    }
}
