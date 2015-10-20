<?php
namespace MailCatcher;

use Carbon\Carbon;

class Mail
{

    /** @var MailCatcher */
    private $mailCatcher;

    private $id;

    private $sender;

    private $recipients;

    private $subject;

    private $size;

    private $createdAt;

    /** @var array */
    private $message;

    public function __construct(MailCatcher $mailCatcher, $id, $sender, array $recipients, $subject, $size, $createdAt)
    {
        $this->mailCatcher = $mailCatcher;
        $this->id = $id;
        $this->sender = $sender;
        $this->recipients = $recipients;
        $this->subject = $subject;
        $this->size = $size;
        $this->createdAt = new Carbon($createdAt);
    }

    public function sender()
    {
        return $this->sender;
    }

    public function recipients()
    {
        return $this->recipients;
    }

    public function subject()
    {
        return $this->subject;
    }

    public function size()
    {
        return $this->size;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }

    /**
     * Get the message data.
     * @return array
     */
    private function message()
    {
        if (null === $this->message) {
            $this->message = $this->mailCatcher->message($this->id);
        }

        return $this->message;
    }

    public function type()
    {
        return $this->message()['type'];
    }

    public function formats()
    {
        return $this->message()['formats'];
    }

    public function hasSource()
    {
        return in_array('source', $this->message()['formats']);
    }

    public function source()
    {
        return $this->message()['source'];
    }

    public function hasHtml()
    {
        return in_array('html', $this->message()['formats']);
    }

    public function html()
    {
        if (!$this->hasHtml()) {
            throw new MailCatcherException('This message has no HTML body.');
        }

        return $this->mailCatcher->messageHtml($this->id);
    }

    public function hasText()
    {
        return in_array('plain', $this->message()['formats']);
    }

    public function text()
    {
        if (!$this->hasText()) {
            throw new MailCatcherException('This message has no text body.');
        }

        return $this->mailCatcher->messageText($this->id);
    }

    public function attachments()
    {
        $attachments = [];

        foreach ($this->message()['attachments'] as $cid) {
            $attachments[] = $this->mailCatcher->messageAttachment($this->id, $cid);
        }

        return $attachments;
    }
}
