<?php

namespace MailCatcher;

class MailCollection
{

    private $mailCatcher;

    public function __construct(MailCatcher $mailCatcher)
    {
        $this->mailCatcher = $mailCatcher;
    }

    public function count()
    {
        return 2;
    }

    public function first()
    {
        return new Mail($this->mailCatcher, 'id', 'sender', ['recipients'], 'Subject 1', 'size', '2015-10-19');
    }
}
