<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CaracteristicasEnum extends Enum
{
    const banheiro = 0;
    const garagem = 1;
    const lavanderia = 2;
    const quarto = 3;
    const suite = 4;
    const area_util = 5;
    
    public function toArray()
    {
        return $this;
    }
}
