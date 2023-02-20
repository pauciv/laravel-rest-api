<?php

namespace App\Services;

class CountWordsService {
    public function count(string $text): int
    {
        return str_word_count($text);
    }
}
