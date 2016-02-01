<?php

namespace spec\MailCatcher;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailCatcherAdapterSpec extends ObjectBehavior
{

    /** @var ClientInterface */
    private $client;

    function let(ClientInterface $client)
    {
        $this->client = $client;

        $this->beConstructedWith($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('MailCatcher\MailCatcherAdapter');
    }

    function it_should_return_some_messages(ResponseInterface $response)
    {
        $this->client->request('GET', '/messages')->willReturn($response);
        $response->getBody()->willReturn(json_encode($this->getMessages()));

        $this->messages()->shouldReturn($this->getMessages());
    }

    function it_should_remove_all_messages()
    {
        $this->client->request('DELETE', '/messages')->shouldBeCalled();

        $this->removeMessages();
    }

    function it_should_return_a_message(ResponseInterface $response)
    {
        $this->client->request('GET', '/messages/id.json')->willReturn($response);
        $response->getBody()->willReturn(json_encode(['message']));

        $this->message('id')->shouldReturn(['message']);
    }

    function it_should_return_a_message_body_html(ResponseInterface $response)
    {
        $this->client->request('GET', '/messages/id.html')->willReturn($response);
        $response->getBody()->willReturn('html');

        $this->messageHtml('id')->shouldReturn('html');
    }

    function it_should_return_a_message_body_text(ResponseInterface $response)
    {
        $this->client->request('GET', '/messages/id.plain')->willReturn($response);
        $response->getBody()->willReturn('text');

        $this->messageText('id')->shouldReturn('text');
    }

    function it_should_return_a_message_attachment(ResponseInterface $response)
    {
        $this->client->request('GET', '/messages/id/cid')->willReturn($response);
        $response->getBody()->willReturn('attachment');

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
