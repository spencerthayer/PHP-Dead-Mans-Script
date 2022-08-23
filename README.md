# Simple Dead Man's Script

Based on existing Dead Man's Scripts long lost.

## Requirements

Requires PHP with an Apache server capable of using cron jobs and email. No special databases are required.


## What SDMS Does
- SDMS uses a simple counter that increments by 1 with each CronJob action.
- Every X days SDMS sends a "check-in" e-mail to a specified e-mail address.
- The email has a link which resets a counter.
- When clicked, the counter resets to 0.
- Once X number of days have passed without a check-in the system begins sending DMS messages to designated recipients.
- E-mails are in plain text format.


## Installation

Unzip the distribution archive to a folder on an Apache web server and run the `initialize.sh`. Ensure the `data/` subdirectory exists with the appropriate 755 permissions.

Or paste this in your SSH session:
```sh
echo 0 > daynum.dat;echo 0 > token.dat;chmod +w daynum.dat;chmod +w token.dat;[ -d data ] || mkdir data;echo order deny,allow > data/.htaccess;echo deny from all >> data/.htaccess;
```


## Configuration

Variables must be configured in the `globals.php` file.

- `baseFolder`: The full path to the installation directory.
- `dataFile`: The full path and filename of the `daynum.dat` file.
- `footerFile`: The full path and filename of the `footer.txt` file.
- `tokenFile`: The full path and filename of the `token.dat` file.
- `checkInterval`: The interval at which check-in e-mails should be sent.  Most users will want to set this at around 5 to 7 days.
- `sendAfter`: The number of days to wait for check-in before releasing messages to recipients.  Can be anything greater than - - `checkInterval`, but ideally should be 3 to 4 times the `checkInterval` value to avoid unintentional misfires.
- `webPath`: The full web address that corresponds to the location where PHP-DMS is installed.
- `ownerMail`: The e-mail address to which check-in messages should go.
- `mailFrom`: The `From:` address for all PHP-DMS e-mails.
- `subjectPrefix`: The prefix for the `Subject:` line of all messages.


## Message Folder Structure

Sadly messages are organized as folders. (*This is a shitty way to do things.*)

The folder structure is / recipient e-mail address / sending after day / message file

The sending after day is the number of days after the sendAfter value in `globals.php`.

```
A file called `data/crow@mst3k.tv/0/message` will be sent to crow@mst3k.tv on the `sendAfter` date.
```
```
A file called `data/mike@mst3k.tv/7/message` will be sent to mike@mst3k.tv 7 days after the `sendAfter` date.
```

Each folder can contain an unlimited number of plain text message files.  The file name will be used as the e-mail subject line. It is not necessary to include a .txt extension.

Numbered folders should be entirely numeric without no special characters, no letters. Leading zeroes are okay. The DMS looks at the base 10 integer value equivalent of the folder name.

## CronJob Script

The script should be called from cron.  A possible crontab entry would be:

    @daily /usr/bin/php -f $HOME/path/to/sdms/run.php

## Security

There is an `htaccess` file in to restrict remote access to the directory. Rename the file for Apache installation to `.htaccess`.

If you want secure the DATA folder and `checkin.php` file using `.htaccess` restrictions:
```
/usr/bin/htpasswd -c .htpasswd username
```
