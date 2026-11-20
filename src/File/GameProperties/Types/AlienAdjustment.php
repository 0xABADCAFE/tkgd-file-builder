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
        $this->assertScale($iScaleWidth, 'ScaleWidth');

        $iScaleHeight = (int)($oSource->ScaleHeight ?? 100);
        $this->assertScale($iScaleHeight, 'ScaleHeight');

        $iVertOffset  = (int)($oSource->VertOffset ?? 0);
        $this->assertOffset($iVertOffset, 'VertOffset');

        $iAuxXOffset    = (int)($oSource->AuxXOffset ?? 0);
        $this->assertOffset($iAuxXOffset, 'AuxXOffset');

        $iAuxYOffset    = (int)($oSource->AuxYOffset ?? 0);
        $this->assertOffset($iAuxYOffset, 'AuxYOffset');

        $iBulletXOffset = (int)($oSource->BulletXOffset ?? 0);
        $this->assertOffset($iBulletXOffset, 'BulletXOffset');

        $iBulletYOffset = (int)($oSource->BulletYOffset ?? 0);
        $this->assertOffset($iBulletYOffset, 'BulletYOffset');

        $iScaleWidth  = (int)(self::SCALE_FACTOR * $iScaleWidth);
        $iScaleHeight = (int)(self::SCALE_FACTOR * $iScaleHeight);

        $this->sPayload = pack(
            self::PACK_WORD . self::PACK_MANY,
            $iAlienID,
            $iScaleWidth,
            $iScaleWidth,
            $iVertOffset,
            $iAuxXOffset,
            $iAuxYOffset,
            $iBulletXOffset,
            $iBulletYOffset
        );
    }

    public function toBinary(): string {
        return $this->sPayload;
    }

    private function assertScale(int $iValue, string $sProperty): void {
        if ($iValue < self::MIN_SCALE || $iValue > self::MAX_SCALE) {
            throw new RuntimeException(
                sprintf(
                    'AlienAdjustment.%s must be between %d and %d',
                    $sProperty,
                    self::MIN_SCALE,
                    self::MAX_SCALE
                )
            );
        }
    }

    private function assertOffset(int $iValue, string $sProperty): void {
        if ($iValue < self::MIN_OFFSET || $iValue > self::MAX_OFFSET) {
            throw new RuntimeException(
                sprintf(
                    'AlienAdjustment.%s must be between %d and %d',
                    $sProperty,
                    self::MIN_OFFSET,
                    self::MAX_OFFSET
                )
            );
        }
    }
}
