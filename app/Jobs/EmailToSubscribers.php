<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\PostEmail;

class EmailToSubscribers implements ShouldQueue
{
    use Dispatchable,
    InteractsWithQueue,
    Queueable,
        SerializesModels;

    private $posts;

    /**
     * Create a new job instance.
     */
    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = [];
        if ($this->posts) {
            foreach ($this->posts as $_post) {
                $data['title'] = $_post['title'];
                $data['description'] = $_post['description'];
                foreach ($_post['website']['user_websites'] as $_user) {
                    $emails[] = $_user['user']['email'];
                }
                $mail = Mail::send(
                    'templates.post_details',
                    array('data' => $data),
                    function ($message) use ($emails) {
                        $message->from('sharmasuraj41@gmail.com', 'Website Subscription Portal')->to($emails)->subject('Website Subscription Portal - New post!');
                    }
                );
                //Add post id to post mail table
                $postupdate = PostEmail::create(['post_id'=>$_post['id'],'status'=>1]);
            }
        }
    }
}
