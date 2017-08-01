# Forum

This is a basic forum application built using Laravel and Vue.js. It contains threads, replies to those threads, and the ability to favorite a reply. The code is written using test-driven development and PHPUNIT. In order to create or reply to thread, please log-in.

## Documentation
* A user has many threads, a user has many replies
* A thread has many replies 
* A reply belongs to a thread and a user 
* A thread belongs to a channel and a user  
* A channel has many threads 
* A reply is "favoritable" - trait 
* A favorite belongs to a reply 

## To run it on localhost 
* vagrant ssh
* php artisan migrate 
* no need to start a development server
* make sure there is at least one channel in the database, otherwise you can't create a new post 