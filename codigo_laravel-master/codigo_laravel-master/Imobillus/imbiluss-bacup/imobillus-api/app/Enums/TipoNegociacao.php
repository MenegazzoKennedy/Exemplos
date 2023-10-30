<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TipoNegociacao extends Enum
{
    const QueroFinanciar =   0;
    const PagamentoaVista =   1;
    const JaPossuoFinanciamento = 2;

    public function toArray()
    {
        return $this;
    }
}
