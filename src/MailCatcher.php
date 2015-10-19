<?php

namespace MailCatcher;

use Guzzle\Http\ClientInterface;

class MailCatcher
{

    /** @var ClientInterface */
    private $httpClient;

    /**
     * Initialize the MailCatcherClient.
     * The URL should match the MailCatcher URL (port included).
     *
     * @param ClientInterface $httpClient
     * @param string $url
     */
    public function __construct(ClientInterface $httpClient, $url)
    {
        $this->httpClient = $httpClient;
        $this->httpClient->setBaseUrl(trim($url, '/'));
    }

    /**
     * Get all messages.
     *
     * @return mixed
     */
    public function messages()
    {
        $messages = $this->httpClient
            ->get('/messages')
            ->send()
            ->json();

        return new MailCollection($messages);
    }

    /**
     * Remove all emails.
     */
    public function removeEmails()
    {
        $this->httpClient
            ->delete('/messages')
            ->send();
    }
}
