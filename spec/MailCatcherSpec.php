<?php

namespace spec\MailCatcher;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\EntityEnclosingRequestInterface;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailCatcherSpec extends ObjectBehavior
{

    /** @var ClientInterface */
    private $client;

    private $url = 'http://url-to-mailcatcher.com';

    function let(ClientInterface $client)
    {
        $this->client = $client;

        $this->beConstructedWith($client, $this->url);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MailCatcher\MailCatcher');
    }

    function it_should_return_some_messages(RequestInterface $request, Response $response)
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

        $this->client->setBaseUrl($this->url)->shouldBeCalled();
        $this->client->get('/messages')->willReturn($request);
        $request->send()->willReturn($response);
        $response->json()->willReturn(json_encode($messages));

        $result = $this->messages();

        $result->shouldBeAnInstanceOf('MailCatcher\MailCollection');
        $result->count()->shouldReturn(2);
        $result->first()->subject()->shouldReturn('Subject 1');
    }

    function it_should_remove_all_emails(EntityEnclosingRequestInterface $request)
    {
        $this->client->setBaseUrl($this->url)->shouldBeCalled();
        $this->client->delete('/messages')->willReturn($request);
        $request->send()->shouldBeCalled();

        $this->removeEmails();
    }
}
