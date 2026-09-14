<?php

declare(strict_types=1);

namespace TKG\Mod\File\GameProperties\Chunkable;

use TKG\Mod\File\GameProperties\Types;
use TKG\Mod\Common;
use \stdClass;
use \RuntimeException;

class DefaultGlobals implements Common\IBinaryEncodable {

    public const string IDENT = 'GBDF';


    public function __construct(
        private readonly stdClass $oDefaultGlobals,
        private Common\StringList $oStringList,
        private Common\HashFNV1A  $oHasher
    ) {

    }

    public function toBinary(): string {
        $sData = '';

        $sPack = Common\IBinaryProperties::PACK_LONG . Common\IBinaryProperties::PACK_LONG;

        foreach ($this->oDefaultGlobals as $sKey => $mValue) {

            $iHash = $this->oHasher->hash($sKey);
            printf("\t0x%08X [%s]\n", $iHash, $sKey);
            if (is_int($mValue)) {
                $sData .= pack($sPack, $iHash, $mValue);
            } else if (is_string($mValue)) {
                $sData .= pack($sPack, $iHash, $this->oStringList->add($mValue));
            } else {
                throw RuntimeException('Unsupported type for global');
            }
        }
        return $sData;
    }

}
