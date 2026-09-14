<?php

/**
 * TKG Redux Mod Builder
 */
declare(strict_types=1);

namespace TKG\Mod\Common;

use \RuntimeException;

/**
 * String hasher that tracks already hashed strings and can raise an exception for any colliding
 * cases.
 *
 * Hash is the FNV1A fast 32-bit
 */
class HashFNV1A {

    private array $arrKeyHashPairs = [];
    private array $arrHashKeyPairs = [];

    private const int HASH_BASE  = 0x811C9DC5;
    private const int HASH_PRIME = 0x01000193;

    public function hash(string $strInput): int {
        if (isset($this->arrKeyHashPairs[$strInput])) {
            return $this->arrKeyHashPairs[$strInput];
        }
        $intHash = $this->calc($strInput);
        if (isset($this->arrHashKeyPairs[$intHash])) {
            throw new RuntimeException(
                sprintf(
                    'Hash collision detected 0x%08f matches both "%s" and existing "%s"',
                    $intHash,
                    $strInput,
                    $this->arrHashKeyPairs[$intHash]
                )
            );
        }
        $this->arrKeyHashPairs[$strInput] = $intHash;
        $this->arrHashKeyPairs[$intHash]  = $strInput;
        return $intHash;
    }

    private function calc(string $strInput): int {
        $intHash = self::HASH_BASE;
        $intLen  = strlen($strInput);
        for ($i = 0; $i < $intLen; ++$i) {
            $intHash ^= ord($strInput[$i]);
            $intHash = ($intHash * self::HASH_PRIME) & 0xFFFFFFFF;
        }
        return $intHash;
    }
}
