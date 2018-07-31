<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $text;
    protected $chat;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($text, $chat)
    {
        $this->text = $text;
        $this->chat = $chat;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Telegram::sendMessage([
            'chat_id' => $this->chat, 
            'text' => $this->text
        ]);
    }
}
