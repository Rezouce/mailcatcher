<?php

namespace MailCatcher;

class MailCollection
{

    public function count()
    {
        return 2;
    }

    public function first()
    {
        return new Mail;
    }
}
