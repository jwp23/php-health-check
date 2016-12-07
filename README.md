# php-health-check
A health check for php projects that goes beyond checking whether php can run

## Raison d'etre
Normally health checks for php applications just check whether a php file with the health check url returns 200. We ran into a case where our Network Operations Center (NOC) wanted more detailed diagnostics for WordPress instances. Over a course of 2+ years we had come across many reasons for WordPress to go down, from missing files from the build and deploy to databases going down. In the process of putting together a health check that did a more thorough check as well as provide diagnostics when a status url is hit, I created a tool that could be easily extended to create any diagnostics one may wish for a PHP application.

## Project Status
After doing a rewrite in repsonse to code review, I ran out of time before we had to go live. Changing to a builder pattern meant my tests were obsolete. This hasn't been tested on a live site and it's not recommended this is used on a production site without more extensive testing. The project is here mainly to showcase my current coding style and for when I have bandwidth in my personal time to test it. The example files are up to date and showcase how the appliction is meant to be used.

## To Do
* Write unit tests
* Test functionality does what it theoretically is supposed to do
* Write acceptance tests
