<?php

namespace spec\MailCatcher;

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\EntityEnclosingRequestInterface;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailCatcherAdapterSpec extends ObjectBehavior
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
        $this->shouldHaveType('MailCatcher\MailCatcherAdapter');
    }

    function it_should_return_some_messages(RequestInterface $request, Response $response)
    {
        $this->client->setBaseUrl($this->url)->shouldBeCalled();
        $this->client->get('/messages')->willReturn($request);
        $request->send()->willReturn($response);
        $response->json()->willReturn($this->getMessages());

        $result = $this->messages()->shouldReturn($this->getMessages());
    }

    function it_should_remove_all_messages(EntityEnclosingRequestInterface $request)
    {
        $this->client->setBaseUrl($this->url)->shouldBeCalled();
        $this->client->delete('/messages')->willReturn($request);
        $request->send()->shouldBeCalled();

        $this->removeMessages();
    }

    function it_should_return_a_message(RequestInterface $request, Response $response)
    {
        $this->client->setBaseUrl($this->url)->shouldBeCalled();
        $this->client->get('/messages/id.json')->willReturn($request);
        $request->send()->willReturn($response);
        $response->json()->willReturn(['message']);

        $this->message('id')->shouldReturn(['message']);
    }

    function it_should_return_a_message_body_html(RequestInterface $request)
    {
        $this->client->setBaseUrl($this->url)->shouldBeCalled();
        $this->client->get('/messages/id.html')->willReturn($request);
        $request->send()->willReturn('html');

        $this->messageHtml('id')->shouldReturn('html');
    }

    function it_should_return_a_message_body_text(RequestInterface $request)
    {
        $this->client->setBaseUrl($this->url)->shouldBeCalled();
        $this->client->get('/messages/id.plain')->willReturn($request);
        $request->send()->willReturn('text');

        $this->messageText('id')->shouldReturn('text');
    }

    function it_should_return_a_message_attachment(RequestInterface $request)
    {
        $this->client->setBaseUrl($this->url)->shouldBeCalled();
        $this->client->get('/messages/id/cid')->willReturn($request);
        $request->send()->willReturn('attachment');

        $this->messageAttachment('id', 'cid')->shouldReturn('attachment');
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
