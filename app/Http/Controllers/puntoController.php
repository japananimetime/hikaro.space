<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redis;

class puntoController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	static function punto(){
		$response = \Telegram::getUpdates();
		foreach ($response as  &$message) {
			$message = $message['message'];
			$messageId = $message['message_id'];	
			$tr_message = Redis::hexists($message['chat']['id'], $messageId);
			if(!$tr_message){
				if(isset($message['text'])){
					if($message['text'] == '/punto'){
						if (isset($message['reply_to_message'])){
							if(isset($message['reply_to_message']['text'])){
								$text = $message['reply_to_message']['text'];
								$char_array = preg_split('//u', $text, null, PREG_SPLIT_NO_EMPTY);
								$result = '';
								$d_fr = array('`', 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',',','.',';',"'",'[',']','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','<','>',':','"','{','}','?','/','@','#','$','^','&');
							  	$d_in = array('ё','ф','и','с','в','у','а','п','р','ш','о','л','д','ь','т','щ','з','й','к','ы','е','г','м','ц','ч','н','я','б','ю','ж','э','х','ъ','Ф','И','С','В','У','А','П','Р','Ш','О','Л','Д','Ь','Т','Щ','З','Й','К','Ы','Е','Г','М','Ц','Ч','Н','Я','Б','Ю','Ж','Э','Х','Ъ',',','.','"','№',';',':','?');
								for ($i=0; $i < count($char_array); $i++) { 
									if (preg_match('/[А-Яа-яЁё]/u', $char_array[$i])) {
										$result = $result.str_replace($d_in, $d_fr, $char_array[$i]);
									}
									else{
										$result = $result.str_replace($d_fr, $d_in, $char_array[$i]);
									}
								}
								$response_send = \Telegram::sendMessage([
									'chat_id' => $message['chat']['id'], 
									'text' => $result
								]);
								Redis::hset($message['chat']['id'], $messageId, $result);
							}
							else{
								$response_send = \Telegram::sendMessage([
									'chat_id' => $message['chat']['id'], 
									'text' => 'Брат, там даже текста нет.'
								]);
								Redis::hset($message['chat']['id'], $messageId, 'noText');
							}
						}
						else{
							$response_send = \Telegram::sendMessage([
								'chat_id' => $message['chat']['id'], 
								'text' => 'Слушай, брат, ты хоть сообщение выбери.'
							]);
							Redis::hset($message['chat']['id'], $messageId, 'noText');
						}
					}
					if($message['text'] == '/caps'){
						if (isset($message['reply_to_message'])){
							if(isset($message['reply_to_message']['text'])){
								$text = $message['reply_to_message']['text'];
								$char_array = preg_split('//u', $text, null, PREG_SPLIT_NO_EMPTY);
								$result = '';
								$d_fr = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', 'ё','ф','и','с','в','у','а','п','р','ш','о','л','д','ь','т','щ','з','й','к','ы','е','г','м','ц','ч','н','я','б','ю','ж','э','х','ъ');
							  	$d_in = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', 'Ё', 'Ф','И','С','В','У','А','П','Р','Ш','О','Л','Д','Ь','Т','Щ','З','Й','К','Ы','Е','Г','М','Ц','Ч','Н','Я','Б','Ю','Ж','Э','Х','Ъ');
								for ($i=0; $i < count($char_array); $i++) { 
									if (preg_match('/[А-ЯЁA-Z]/u', $char_array[$i])) {
										$result = $result.str_replace($d_in, $d_fr, $char_array[$i]);
									}
									else{
										$result = $result.str_replace($d_fr, $d_in, $char_array[$i]);
									}
								}
								$response_send = \Telegram::sendMessage([
									'chat_id' => $message['chat']['id'], 
									'text' => $result
								]);
								Redis::hset($message['chat']['id'], $messageId, $result);
							}
							else{
								$response_send = \Telegram::sendMessage([
									'chat_id' => $message['chat']['id'], 
									'text' => 'Слушай, брат, там даже текста нет.'
								]);
								Redis::hset($message['chat']['id'], $messageId, 'noText');
							}
						}
						else{
							$response_send = \Telegram::sendMessage([
								'chat_id' => $message['chat']['id'], 
								'text' => 'Слушай, брат, ты хоть сообщение выбери.'
							]);
							Redis::hset($message['chat']['id'], $messageId, 'noText');
						}
					}
				}
			}
		}
	}

	function testMessage(){
		$response = \Telegram::getUpdates();
		$message = end($response)['message'];
		$response = \Telegram::sendMessage([
			'chat_id' => $message['chat']['id'], 
			'text' => '@japananimetime'
		]);
	}
}
