<?php

namespace Lang;

use Lang\Interface\Words;

class Translate {

    public $words;
    function __construct(Words $words) {
        $this->words = $words;
    }

    public function t(string $word, $locale) {
        return $this->words->$locale()[$word];
    }

}

