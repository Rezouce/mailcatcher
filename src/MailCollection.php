<?php

namespace MailCatcher;

class MailCollection implements \IteratorAggregate
{

    private $mailCatcher;

    private $mails = [];

    /**
     * @param MailCatcher $mailCatcher
     * @param array $messages
     */
    public function __construct(MailCatcher $mailCatcher, array $messages)
    {
        $this->mailCatcher = $mailCatcher;

        foreach ($messages as $message) {
            $this->mails[] = $this->createMail($mailCatcher, $message);
        }
    }

    /**
     * Create a mail from a MailCatcher message.
     *
     * @param MailCatcher $mailCatcher
     * @param array $message
     * @return Mail
     */
    private function createMail(MailCatcher $mailCatcher, array $message)
    {
        return new Mail(
            $mailCatcher,
            $message['id'],
            $message['sender'],
            $message['recipients'],
            $message['subject'],
            $message['size'],
            $message['created_at']
        );
    }

    /**
     * The number of mails.
     *
     * @return int
     */
    public function count()
    {
        return count($this->mails);
    }

    /**
     * Get the first mail.
     *
     * @return Mail
     * @throws MailCatcherException
     */
    public function first()
    {
        if (empty($this->mails)) {
            throw new MailCatcherException('There is no email in this collection.');
        }

        return $this->mails[0];
    }

    /**
     * Get the last mail.
     *
     * @return Mail
     * @throws MailCatcherException
     */
    public function last()
    {
        if (empty($this->mails)) {
            throw new MailCatcherException('There is no email in this collection.');
        }

        return end($this->mails);
    }

    /**
     * Get the n mail.
     *
     * @param int $number
     * @return Mail
     * @throws MailCatcherException
     */
    public function get($number)
    {
        if (count($this->mails) < $number + 1) {
            throw new MailCatcherException(
                sprintf('You tried to get the %s when there is only %s emails.', $number, count($this->mails))
            );
        }

        return $this->mails[$number];
    }

    /**
     * Get the iterator.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->mails);
    }
}
