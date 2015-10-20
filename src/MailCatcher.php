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
     * @return MailCollection
     */
    public function messages()
    {
        $messages = $this->httpClient
            ->get('/messages')
            ->send()
            ->json();

        return new MailCollection($this, $messages);
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

    /**
     * Get the data from a message.
     *
     * @param int $id
     * @return array
     */
    public function message($id)
    {
        return $this->httpClient
            ->get('/messages/' . $id . '.json')
            ->send()
            ->json();
    }

    /**
     * Get a message's HTML body.
     *
     * @param int $id
     * @return string
     */
    public function messageHtml($id)
    {
        return $this->httpClient
            ->get('/messages/' . $id . '.html')
            ->send();
    }

    /**
     * Get a message's text body.
     *
     * @param int $id
     * @return string
     */
    public function messageText($id)
    {
        return $this->httpClient
            ->get('/messages/' . $id . '.plain')
            ->send();
    }

    /**
     * Get a message's attachment.
     *
     * @param int $id
     * @param string $cid
     * @return string
     */
    public function messageAttachment($id, $cid)
    {
        return $this->httpClient
            ->get('/messages/' . $id . '/' . $cid)
            ->send();
    }
}
