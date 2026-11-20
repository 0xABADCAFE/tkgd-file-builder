<?php

declare(strict_types=1);

namespace TKG\Mod\File\GameProperties\Chunkable;

use TKG\Mod\File\GameProperties\Types;
use TKG\Mod\Common;
use \stdClass;
use \RuntimeException;

class AlienAdjustments implements Common\IBinaryEncodable {

    public const string IDENT = 'AADJ';

    public function __construct(
        private readonly array    $aAlienTypes,
        private readonly stdClass $oAlienAdjustments
    ) {

    }

    public function toBinary(): string {
        $sData = '';
        foreach ($this->oAlienAdjustments as $sAlienName => $oAlienAdjustmentDef) {
            $iAlienID = $this->aAlienTypes[$sAlienName] ??
                throw new RuntimeException('Invalid Alien Name ' . $sAlienName);
            $oAlienAdjustment = new Types\AlienAdjustment(
                $oAlienAdjustmentDef,
                $iAlienID
            );
            $sData .= $oAlienAdjustment->toBinary();
        }
        return $sData;
    }

}
