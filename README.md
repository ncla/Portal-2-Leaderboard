To have leaderboards up and running, you need:
1) Basic LAMP webserver
2) PHP cURL extension and PHP APC extension installed
3) Apache mod_rewrite and mod_expires enabled for image caching to work and for beautiful URLs

Once you have those, import database dump provided in repisotory, change database settings in db_conf.php file.
To get APC caches working, run refreshcache.php from browser.

Optional: change Steam API developer key to your own for testing purposes.