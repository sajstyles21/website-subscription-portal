# Website Subscription Portal

Run `composer update`

Run `php artisan db:seed` for website and users seeding

Start server by command `php artisan serve`

Swagger link to test APIS - 
http://127.0.0.1:8000/api/documentation

Command to send email to subscribers for new post added - 
`php artisan sendemail:subscribers`

NOTE - No queue or command will run when you add new post to website by an API. You have to run command `php artisan sendemail:subscribers` for sending new post email to all subscribers for that post's website as discussed with you.