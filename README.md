live
====

Live is a simple php script to monitor multiple service on the server.
When we handle many servers, we need to know healthy of all the important service by one-time config.

This script will return string like this for monitor to watch services.
> ok db:ok memcache:_ smtp:ok backend:ok

Place this script to website, this can called by remote service then response available service in string.
External monitor service such as:
* [pingdom](https://www.pingdom.com)  or
* [uptime](https://github.com/fzaninotto/uptime) of nodejs or
* [monit](http://mmonit.com/monit/) of linux

Install
-------

> cd to_your_web_dir
> git clone git://github.com/jimyhuang/live.git
> cd live
> cp config.sample.inc config.inc

config (detail description config)
> vim confic.inc

test
> wget http://your_host/live/live.php

Static version
--------------

You can also use cron to trigger this script.
Then provide static page for monitor service to prevent overhead.

Cron setting
> crontab -e

Then add this line
> */3 * * * * wget -O - -q -t 1 http://your_host/live/live.php

After cron success triggered, add url to external service
> http://your_host/live/live.htm


TODO
----
More protocol support.

LICENSE
-------

CC0 Public Domain
