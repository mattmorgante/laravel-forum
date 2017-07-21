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

## Ideas 
Pre-populated list of categories 
* Make it so tht you can create a category!! 
* Roll back to pre-heroku config so that you can continue local development 
* Learn how to setup local and production environments with laravel and heroku (maybe even full DTAP)
* See the channel of a post on the post page 
* Add images to posts and layout to the homepage
* New category: recipes 
* Two views: Admin for writing posts and users for starting discussions 
* Users can create posts within categories 
* Users can answer posts within categories 
* Users can view a visualization of their data 
* Moderators can post content - longer pieces that are pinned to the home page. 
* Look at IBM watson and tensorflow APIs for integration 
* Should it be generating revenue or generating data? 
* Users can comment on content
``