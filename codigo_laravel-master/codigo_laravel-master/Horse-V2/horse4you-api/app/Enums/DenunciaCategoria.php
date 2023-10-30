<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DenunciaCategoria extends Enum
{
    const BaixoCalao = 1;
    const Ofencivo = 2;
    const outro =  0;
}
