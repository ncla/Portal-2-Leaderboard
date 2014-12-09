To have leaderboards up and running, you need:
1) Basic LAMP webserver
2) PHP cURL extension and PHP APC extension installed
3) Apache mod_rewrite and mod_expires enabled for image caching to work and for beautiful URLs

Once you have those, import database dump provided in repisotory, change database settings in db_conf.php file.
To get APC caches working, run refreshcache.php from browser.

Please keep in mind that this was created when trying to learn OOP/MVC and I have lost interest in continuing to build this, therefor this code can be still improvable.

Required: change Steam API developer key to your own in /models/users.php, line 57.

Software licensed under CC Attribution - Non-commercial license.
https://creativecommons.org/licenses/by-nc/4.0/legalcode