<?php

namespace App\Http\Controllers\API;

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
        $text = $message['reply_to_message']['text'];
        $char_array = preg_split('//u', $text, null, PREG_SPLIT_NO_EMPTY);
        $result = '';
        $d_fr = array('`', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', ',', '.', ';', "'", '[', ']', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '<', '>', ':', '"', '{', '}', '?', '/', '@', '#', '$', '^', '&');
        $d_in = array('ё', 'ф', 'и', 'с', 'в', 'у', 'а', 'п', 'р', 'ш', 'о', 'л', 'д', 'ь', 'т', 'щ', 'з', 'й', 'к', 'ы', 'е', 'г', 'м', 'ц', 'ч', 'н', 'я', 'б', 'ю', 'ж', 'э', 'х', 'ъ', 'Ф', 'И', 'С', 'В', 'У', 'А', 'П', 'Р', 'Ш', 'О', 'Л', 'Д', 'Ь', 'Т', 'Щ', 'З', 'Й', 'К', 'Ы', 'Е', 'Г', 'М', 'Ц', 'Ч', 'Н', 'Я', 'Б', 'Ю', 'Ж', 'Э', 'Х', 'Ъ', ',', '.', '"', '№', ';', ':', '?');
        for ($i = 0; $i < count($char_array); $i++) {
            if (preg_match('/[А-Яа-яЁё]/u', $char_array[$i])) {
                $result = $result . str_replace($d_in, $d_fr, $char_array[$i]);
            } else {
                $result = $result . str_replace($d_fr, $d_in, $char_array[$i]);
            }
        }
        Telegram::sendMessage([
            'chat_id' => $message['chat']['id'],
            'text' => $result
        ]);
        $this->saveMessage($message['chat']['id'], $message['message_id'], $result);
    }

    private function capsBot($message)
    {
        $text = $message['reply_to_message']['text'];
        $char_array = preg_split('//u', $text, null, PREG_SPLIT_NO_EMPTY);
        $result = '';
        $d_fr = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'ё', 'ф', 'и', 'с', 'в', 'у', 'а', 'п', 'р', 'ш', 'о', 'л', 'д', 'ь', 'т', 'щ', 'з', 'й', 'к', 'ы', 'е', 'г', 'м', 'ц', 'ч', 'н', 'я', 'б', 'ю', 'ж', 'э', 'х', 'ъ');
        $d_in = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Ё', 'Ф', 'И', 'С', 'В', 'У', 'А', 'П', 'Р', 'Ш', 'О', 'Л', 'Д', 'Ь', 'Т', 'Щ', 'З', 'Й', 'К', 'Ы', 'Е', 'Г', 'М', 'Ц', 'Ч', 'Н', 'Я', 'Б', 'Ю', 'Ж', 'Э', 'Х', 'Ъ');
        for ($i = 0; $i < count($char_array); $i++) {
            if (preg_match('/[А-ЯЁA-Z]/u', $char_array[$i])) {
                $result = $result . str_replace($d_in, $d_fr, $char_array[$i]);
            } else {
                $result = $result . str_replace($d_fr, $d_in, $char_array[$i]);
            }
        }
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
