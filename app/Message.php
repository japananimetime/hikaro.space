<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\SendReply;
use Illuminate\Support\Facades\Redis;


class Message extends Model
{
	protected $message;

	public function __construct($message)
    {
        $this->message = $message;
    }

    public static function punto()
    {
    	
    }
    public function caps()
    {
    	if (isset($this->message['reply_to_message'])){
			if(isset($this->message['reply_to_message']['text'])){
				$text = $this->message['reply_to_message']['text'];
				$char_array = preg_split('//u', $text, null, PREG_SPLIT_NO_EMPTY);
				$result = '';
				$en = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', 'ё','ф','и','с','в','у','а','п','р','ш','о','л','д','ь','т','щ','з','й','к','ы','е','г','м','ц','ч','н','я','б','ю','ж','э','х','ъ');
			  	$ru = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', 'Ё', 'Ф','И','С','В','У','А','П','Р','Ш','О','Л','Д','Ь','Т','Щ','З','Й','К','Ы','Е','Г','М','Ц','Ч','Н','Я','Б','Ю','Ж','Э','Х','Ъ');
				for ($i=0; $i < count($char_array); $i++) { 
					if (in_array($char_array[$i], $ru)) {
						$result = $result.str_replace($ru, $en, $char_array[$i]);
					}
					else{
						$result = $result.str_replace($en, $ru, $char_array[$i]);
					}
				}
				$job = new SendReply($result, $this->message['chat']['id']);
				$job->dispatch()
    				->onQueue('caps');
				Redis::hset($this->message['chat']['id'], $this->message['message_id'], $result);
    		}
    		else{
    			$responseText = 'Слушай, брат, там даже текста нет.';
    			$job = new SendReply($responseText, $this->message['chat']['id']);
    			$job->dispatch()
    				->onQueue('caps');
				Redis::hset($this->message['chat']['id'], $this->message['message_id'], 'noText');
			}
    	}
    	else{
    		$responseText = 'Слушай, брат, ты хоть сообщение выбери.';
    		$job = new SendReply($responseText, $this->message['chat']['id']);
    		$job->dispatch()
    				->onQueue('caps');
			Redis::hset($this->message['chat']['id'], $this->message['message_id'], 'noText');
		}
    }
}
