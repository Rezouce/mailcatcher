<?php

namespace MailCatcher;

use GuzzleHttp\ClientInterface;

class MailCatcherAdapter
{

    /** @var ClientInterface */
    private $httpClient;

    /**
     * Initialize the MailCatcherClient.
     * The URL should match the MailCatcherAdapter URL (port included).
     *
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get all messages.
     *
     * @return array
     */
    public function messages()
    {
        return json_decode(
            $this->httpClient->request('GET', '/messages')->getBody(),
            true
        );
    }

    /**
     * Remove all emails.
     */
    public function removeMessages()
    {
        $this->httpClient->request('DELETE', '/messages');
    }

    /**
     * Get the data from a message.
     *
     * @param int $id
     * @return array
     */
    public function message($id)
    {
        return json_decode(
            $this->httpClient->request('GET', '/messages/' . $id . '.json')->getBody(),
            true
        );
    }

    /**
     * Get a message's HTML body.
     *
     * @param int $id
     * @return string
     */
    public function messageHtml($id)
    {
        return $this->httpClient->request('GET', '/messages/' . $id . '.html')->getBody();
    }

    /**
     * Get a message's text body.
     *
     * @param int $id
     * @return string
     */
    public function messageText($id)
    {
        return $this->httpClient->request('GET', '/messages/' . $id . '.plain')->getBody();
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
        return $this->httpClient->request('GET', '/messages/' . $id . '/' . $cid)->getBody();
    }
}
