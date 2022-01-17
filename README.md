# Website Subscription Portal

Run `composer update`

copy .env.example to .env and add SMTP mail and DB credentials.

Run `php artisan migrate` for migrations.

Run `php artisan db:seed` for website and users seeding

Start server by command `php artisan serve`

Swagger link to test APIS - 
http://127.0.0.1:8000/api/documentation

Command to send email to subscribers for new post added - 
`php artisan sendemail:subscribers`

NOTE - No queue or command will run when you add a new post to the website by an API. You have to run the command `php artisan sendemail:subscribers` for sending a new post email to all subscribers for that post's website as discussed with you.

This command will check all new posts added and then start a `job queue` for sending an email to this post's website subscribers and when you hit this command again, this will look for new posts added as no duplicate emails will be sent to subscribers.