<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Generos extends Enum
{
    const Masculino = 0;
    const Feminino =   1;
    const Outro = 2;
    public function toArray()
    {
        return $this;
    }
}
