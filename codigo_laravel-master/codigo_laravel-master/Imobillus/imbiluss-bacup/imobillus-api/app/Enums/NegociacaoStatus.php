<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class NegociacaoStatus extends Enum
{
    const pre_aprovado = 0;
    const aprovado =   1;
    const cancelado = 2;
    const finalizado = 3;
    const aguardando_revisão = 4;
    public function toArray()
    {
        return $this;
    }
}
