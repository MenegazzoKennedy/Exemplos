<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Descricao extends Enum
{
    const AreaUtil = 0;
    const Banheiros = 1;
    const Garagem = 2;
    const latitude = 3;
    const longitude = 4;
    const Lavanderia = 5;
    const Quartos = 6;
    const Suíte = 7;
    const Youtube = 8;
    const Tour360 = 9;
    const Unidades = 10;
    public function toArray()
    {
        return $this;
    }
}
