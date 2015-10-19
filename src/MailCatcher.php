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
        // TODO
        return $id;
    }

    /**
     * Get a message's HTML body.
     *
     * @param int $id
     * @return string
     */
    public function messageHtmlBody($id)
    {
        // TODO
        return $id;
    }

    /**
     * Get a message's text body.
     *
     * @param int $id
     * @return string
     */
    public function messageTextBody($id)
    {
        // TODO
        return $id;
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
        // TODO
        return $cid;
    }
}
