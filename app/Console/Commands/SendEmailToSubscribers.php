<?php

namespace App\Console\Commands;

use App\UserWebsite;
use Illuminate\Console\Command;
use App\Jobs\EmailToSubscribers;
use App\User;
use App\Post;
use Mail;

class SendEmailToSubscribers extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendemail:subscribers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to subscribers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $posts = Post::with('website', 'website.user_websites.user')->doesntHave('post_email')->has('website.user_websites')->get()->toArray();
     
        EmailToSubscribers::dispatch($posts);
    }
}
