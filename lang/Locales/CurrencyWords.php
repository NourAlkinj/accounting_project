<?php

namespace Lang\Locales;

use Lang\interface\Words;

enum CurrencyWordsEnum {

      case parity_condition;
}

class CurrencyWords implements Words
{

  function en(): array
  {
    return [
      'parity_condition'=>'Parity Can not be 0.',
    ];
  }

  function ar(): array
  {
    return [
      'parity_condition'=>'التعادل لايمكن أن يكون صفر.',
    ];
  }

}
