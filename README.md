# smtp-sender
Simple script for sending e-mails via the browser.
Content formatting via Markdown possible.

## Installation

To install smtp-sender, connect with SSH to your server and change to your webservers (document) root directory. You need to install Git and Composer if you haven’t already.

```console
git clone https://github.com/Memurame/smtp-sender.git
cd smtp-sender/
```

Now install all dependencies:
```console
composer install
```

Copy the file config_example.php to config.php and add the SMTP credentials.

## Cron
For smtp-sender to work properly, a CronJob needs to be run regularly to send email im background. I recommend an interval of 5 minutes.

Directly via console:
```console
/[PATH_TO_YOUR_SITE]/cron.php
```

If your SMTP server has a send limit per hour, you can define this in config.php.
 
