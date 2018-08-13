<?php

namespace App\Http\Controllers\API;

use App\Package\TextCorrector;
use App\Repositories\MessageRepo;
use Illuminate\Routing\Controller as BaseController;
use Telegram;

class PuntoController extends BaseController
{
    private $repository;

    public function __construct(MessageRepo $repository)
    {
        $this->repository = $repository;
    }

    public function punto()
    {
        $response = Telegram::getUpdates();
        foreach ($response as $message) {
        	if(isset($message['message'])){
        		$this->checkMessage($message);
        	}            
        }
    }

    public function message()
    {
        $response = Telegram::getUpdates();
        $message = end($response)['message'];
        Telegram::sendMessage([
            'chat_id' => '-1001269227868',
            'text' => $_POST['message']
        ]);
        // print_r($response);
    }

    private function checkMessage($data)
    {
        $message = $data['message'];
        $chatId = $message['chat']['id'];
        $messageId = $message['message_id'];

        if (!$this->repository->check($chatId, $messageId) && isset($message['text'])) {
            if (!isset($message['reply_to_message'])) {
                Telegram::sendMessage([
                    'chat_id' => $message['chat']['id'],
                    'text' => 'Слушай, брат, ты хоть сообщение выбери.'
                ]);
                $this->repository->save($chatId, $messageId);
            } elseif (!isset($message['reply_to_message']['text'])) {
                Telegram::sendMessage([
                    'chat_id' => $message['chat']['id'],
                    'text' => 'Брат, там даже текста нет.'
                ]);
                $this->repository->save($message['chat']['id'], $messageId);
            } else {
                switch ($message['text']) {
                    case '/punto':
                        return $this->puntoBot($message);
                        break;
                    case '/caps':
                        return $this->capsBot($message);
                        break;
                    case '/punto@japananimetime_bot':
                        return $this->puntoBot($message);
                        break;
                    case '/caps@japananimetime_bot':
                        return $this->capsBot($message);
                        break;
                }
            }
        }
    }

    private function puntoBot($message)
    {
        $result = app()->make(TextCorrector::class)->punto($message['reply_to_message']['text']);
        Telegram::sendMessage([
            'chat_id' => $message['chat']['id'],
            'text' => $result
        ]);
        $this->saveMessage($message['chat']['id'], $message['message_id'], $result);
    }

    private function capsBot($message)
    {
        $result = app()->make(TextCorrector::class)->capsLock($message['reply_to_message']['text']);
        Telegram::sendMessage([
            'chat_id' => $message['chat']['id'],
            'text' => $result
        ]);
        $this->saveMessage($message['chat']['id'], $message['message_id'], $result);
    }

    private function saveMessage($chatId, $messageId, $result){
    	$this->repository->save($chatId, $messageId, $result);
    }
}
