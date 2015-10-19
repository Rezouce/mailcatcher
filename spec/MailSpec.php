<?php

namespace spec\MailCatcher;

use MailCatcher\MailCatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailSpec extends ObjectBehavior
{

    /** @var MailCatcher */
    private $mailCatcher;

    function let(MailCatcher $mailCatcher)
    {
        $this->mailCatcher = $mailCatcher;

        $this->beConstructedWith($mailCatcher, 'id', 'sender', ['recipients'], 'subject', 'size', '2015-10-19');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MailCatcher\Mail');
    }

    function it_should_return_its_sender()
    {
        $this->sender()->shouldReturn('sender');
    }

    function it_should_return_its_recipients()
    {
        $this->recipients()->shouldReturn(['recipients']);
    }

    function it_should_return_its_subject()
    {
        $this->subject()->shouldReturn('subject');
    }

    function it_should_return_its_size()
    {
        $this->size()->shouldReturn('size');
    }

    function it_should_return_its_creation_date()
    {
        $this->createdAt()->shouldBeAnInstanceOf('Carbon\Carbon');
        $this->createdAt()->format('Y-m-d')->shouldReturn('2015-10-19');
    }

    function it_should_return_its_type()
    {
        $this->mailCatcher->message('id')->willReturn(['type' => 'type']);

        $this->type()->shouldReturn('type');
    }

    function it_should_return_its_formats()
    {
        $this->mailCatcher->message('id')->willReturn(['formats' => ['formats']]);

        $this->formats()->shouldReturn(['formats']);
    }

    function it_should_tell_if_it_hasnt_a_source()
    {
        $this->mailCatcher->message('id')->willReturn(['formats' => []]);

        $this->hasSource()->shouldReturn(false);
    }

    function it_should_tell_if_it_has_a_source()
    {
        $this->mailCatcher->message('id')->willReturn(['formats' => ['source']]);

        $this->hasSource()->shouldReturn(true);
    }

    function it_should_return_its_source()
    {
        $this->mailCatcher->message('id')->willReturn(['source' => 'body']);

        $this->source()->shouldReturn('body');
    }

    function it_should_tell_if_it_hasnt_a_html_body()
    {
        $this->mailCatcher->message('id')->willReturn(['formats' => []]);

        $this->hasHtml()->shouldReturn(false);
    }

    function it_should_tell_if_it_has_a_html_body()
    {
        $this->mailCatcher->message('id')->willReturn(['formats' => ['html']]);

        $this->hasHtml()->shouldReturn(true);
    }

    function it_should_return_its_html_body()
    {
        $this->mailCatcher->message('id')->willReturn(['formats' => ['html']]);
        $this->mailCatcher->messageHtml('id')->willReturn('body');

        $this->html()->shouldReturn('body');
    }

    function it_should_tell_if_it_hasnt_a_plain_body()
    {
        $this->mailCatcher->message('id')->willReturn(['formats' => []]);

        $this->hasText()->shouldReturn(false);
    }

    function it_should_tell_if_it_has_a_plain_body()
    {
        $this->mailCatcher->message('id')->willReturn(['formats' => ['plain']]);

        $this->hasText()->shouldReturn(true);
    }

    function it_should_return_its_plain_body()
    {
        $this->mailCatcher->message('id')->willReturn(['formats' => ['plain']]);
        $this->mailCatcher->messageText('id')->willReturn('body');

        $this->text()->shouldReturn('body');
    }

    function it_should_return_its_attachments()
    {
        $this->mailCatcher->message('id')->willReturn(['attachments' => [1, 2]]);
        $this->mailCatcher->messageAttachment('id', 1)->willReturn('attachment 1');
        $this->mailCatcher->messageAttachment('id', 2)->willReturn('attachment 2');

        $this->attachments()->shouldReturn(['attachment 1', 'attachment 2']);
    }
}
