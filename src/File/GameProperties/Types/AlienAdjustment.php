<?php

declare(strict_types=1);

namespace TKG\Mod\File\GameProperties\Types;

use TKG\Mod\Common;
use \RuntimeException;
use \stdClass;

use function \is_array, \pack;

/**
 * AlienAdjustment
 */
class AlienAdjustment implements Common\IBinaryEncodable {

    private const MIN_SCALE    = 1;
    private const MAX_SCALE    = 200;
    private const SCALE_FACTOR = 2.56; // Percentage to 8.8 fixed
    private const MIN_OFFSET   = -128;
    private const MAX_OFFSET   = 127;
    private string $sPayload   = '';

    public function __construct(
        stdClass $oSource,
        int $iAlienID
    ) {
        if (empty($oSource)) {
            throw new RuntimeException('AlienAdjustment cannot be empty');
        }

        $iScaleWidth  = (int)($oSource->ScaleWidth ?? 100);
        $iScaleHeight = (int)($oSource->ScaleHeight ?? 100);
        $iVertOffset  = (int)($oSource->VertOffset ?? 0);

        if ($iScaleWidth < self::MIN_SCALE || $iScaleWidth > self::MAX_SCALE) {
            throw new RuntimeException(
                sprintf(
                    'AlienAdjustment.ScaleWidth must be between %d and %d',
                    self::MIN_SCALE,
                    self::MAX_SCALE
                )
            );
        }

        if ($iScaleHeight < self::MIN_SCALE || $iScaleHeight > self::MAX_SCALE) {
            throw new RuntimeException(
                sprintf(
                    'AlienAdjustment.ScaleHeight must be between %d and %d',
                    self::MIN_SCALE,
                    self::MAX_SCALE
                )
            );
        }

        if ($iVertOffset < self::MIN_OFFSET || $iVertOffset > self::MAX_OFFSET) {
            throw new RuntimeException(
                sprintf(
                    'AlienAdjustment.VertOffset must be between %d and %d',
                    self::MIN_OFFSET,
                    self::MAX_OFFSET
                )
            );
        }

        $iScaleWidth  = (int)(self::SCALE_FACTOR * $iScaleWidth);
        $iScaleHeight = (int)(self::SCALE_FACTOR * $iScaleHeight);

        $this->sPayload = pack(
            self::PACK_WORD . self::PACK_MANY,
            $iAlienID,
            $iScaleWidth,
            $iScaleWidth,
            $iVertOffset
        );
    }

    public function toBinary(): string {
        return $this->sPayload;
    }
}
