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
        $mails = [];

        foreach ($this->adapter->messages() as $message) {
            $mails[] = $this->createMail($message);
        }

        return new MailCollection($mails);
    }

    /**
     * Create a mail from a MailCatcherAdapter message.
     *
     * @param array $message
     * @return Mail
     */
    private function createMail(array $message)
    {
        return new Mail(
            $this->adapter,
            $message['id'],
            $message['sender'],
            $message['recipients'],
            $message['subject'],
            $message['size'],
            $message['created_at']
        );
    }

    /**
     * Remove all messages.
     */
    public function removeMessages()
    {
        $this->adapter->removeMessages();
    }
}
