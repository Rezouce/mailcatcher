<?php
namespace MailCatcher;

class MailCatcher
{

    private $adapter;

    public function __construct(MailCatcherAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get all messages.
     *
     * @return MailCollection
     */
    public function messages()
    {
        return new MailCollection($this->adapter, $this->adapter->messages());
    }

    /**
     * Remove all messages.
     */
    public function removeMessages()
    {
        $this->adapter->removeMessages();
    }
}
