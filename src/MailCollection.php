<?php

namespace MailCatcher;

class MailCollection implements \IteratorAggregate
{

    private $mails = [];

    /**
     * @param array $mails
     * @throws MailCatcherException
     */
    public function __construct(array $mails)
    {
        foreach ($mails as $mail) {
            if (!$mail instanceof Mail) {
                throw new MailCatcherException('You provided a value which is not a MailCatcher\Mail.');
            }
        }

        $this->mails = $mails;
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
