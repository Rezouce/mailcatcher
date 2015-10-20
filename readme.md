# MailCatcher
This library allow to retrieve/remove messages from MailCatcher.

## Installation
`composer require rezouce/mailcatcher`

## Usage
```php
<?php
use MailCatcher\MailCatcher;
use MailCatcher\MailCatcherAdapter;
use Guzzle\Http\Client;

$urlToMailCatcher = 'http://127.0.0.1:1080';
$adapter = new MailCatcherAdapter(new Client, $urlToMailCatcher);

$mailCatcher = new MailCatcher($adapter);
$mailCatcher->removeMessages(); // Delete all messages
$messages = $mailCatcher->messages(); // Get all messages in a traversable collection

// You can filter messages.
$sender = 'user@example.com';
$messages->filter(function(Mail $message) use ($sender) {
    return $message->sender() === $sender;
});
```

## License
This library is open-sourced software licensed under the MIT license
