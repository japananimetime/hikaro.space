<?php
/**
 * Created by PhpStorm.
 * User: mammut
 * Date: 31.07.18
 * Time: 16:13
 */

namespace App\Package;


class TextCorrector
{
    public function capsLock(string $text): string
    {
        $capital = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Ё', 'Ф', 'И', 'С', 'В', 'У', 'А', 'П', 'Р', 'Ш', 'О', 'Л', 'Д', 'Ь', 'Т', 'Щ', 'З', 'Й', 'К', 'Ы', 'Е', 'Г', 'М', 'Ц', 'Ч', 'Н', 'Я', 'Б', 'Ю', 'Ж', 'Э', 'Х', 'Ъ'];
        $small = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'ё', 'ф', 'и', 'с', 'в', 'у', 'а', 'п', 'р', 'ш', 'о', 'л', 'д', 'ь', 'т', 'щ', 'з', 'й', 'к', 'ы', 'е', 'г', 'м', 'ц', 'ч', 'н', 'я', 'б', 'ю', 'ж', 'э', 'х', 'ъ'];

        return $this->correctTextLiter($text, $capital, $small);
    }

    public function punto(string $text): string
    {
        $en = ['`', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', ',', '.', ';', "'", '[', ']', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '<', '>', ':', '"', '{', '}', '?', '/', '@', '#', '$', '^', '&'];
        $ru = ['ё', 'ф', 'и', 'с', 'в', 'у', 'а', 'п', 'р', 'ш', 'о', 'л', 'д', 'ь', 'т', 'щ', 'з', 'й', 'к', 'ы', 'е', 'г', 'м', 'ц', 'ч', 'н', 'я', 'б', 'ю', 'ж', 'э', 'х', 'ъ', 'Ф', 'И', 'С', 'В', 'У', 'А', 'П', 'Р', 'Ш', 'О', 'Л', 'Д', 'Ь', 'Т', 'Щ', 'З', 'Й', 'К', 'Ы', 'Е', 'Г', 'М', 'Ц', 'Ч', 'Н', 'Я', 'Б', 'Ю', 'Ж', 'Э', 'Х', 'Ъ', ',', '.', '"', '№', ';', ':', '?'];

        return $this->correctTextLiter($text, $en, $ru);
    }

    private function correctTextLiter(string $text, array $from, array $to): string
    {
        return str_replace($from,$to, $text);
    }
}