<?php

namespace spec\MailCatcher;

use MailCatcher\Mail;
use MailCatcher\MailCatcherAdapter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailCollectionSpec extends ObjectBehavior
{

    function let(Mail $mail1, Mail $mail2)
    {
        $messages = [$mail1, $mail2];
        $mail1->subject()->willReturn('Subject 1');
        $mail2->subject()->willReturn('Subject 2');

        $this->beConstructedWith($messages);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MailCatcher\MailCollection');
    }

    function it_should_throw_an_exception_if_something_else_than_mails_are_provided()
    {
        $this->beConstructedWith(['not a Mail']);

        $this->shouldThrow('MailCatcher\MailCatcherException')->duringInstantiation();
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
        $this->beConstructedWith([]);

        $this->shouldThrow('MailCatcher\MailCatcherException')->duringFirst();
    }

    function it_should_return_its_last_mail()
    {
        $this->last()->subject()->shouldReturn('Subject 2');
    }

    function it_should_throw_an_exception_when_trying_to_get_the_last_mail_of_an_empty_collection(MailCatcherAdapter $mailCatcher)
    {
        $this->beConstructedWith([]);

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

    function it_should_filter_its_mails()
    {
        $collection = $this->filter(function(Mail $mail) {
            return $mail->subject() == 'Subject 1';
        });

        $collection->count()->shouldReturn(1);
        $collection->first()->subject()->shouldReturn('Subject 1');
    }
}
