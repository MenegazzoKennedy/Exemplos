<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Fontes extends Enum
{
    const Arial = 0;
    const TimesNewRoman =   1;
    const Helvetica = 2;
    const Times = 3;
    const Verdana = 4;
    const Courier = 5;
    const ArialNarrow = 6;
    const Candara = 7;
    const Geneva = 8;
    const Calibri = 9;
    public function toArray()
    {
        return $this;
    }
}
