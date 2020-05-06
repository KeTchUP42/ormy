<?php
declare(strict_types = 1);

namespace ORMY\Migrator\Source;

/**
 * IDGenerator
 */
class IDGenerator
{
    /**
     * Version version timespan corrector
     *
     * @var int
     */
    private static int $VersionCorrector = 0;

    /**
     * Method returns unique string from timespan
     *
     * @param string $prefix
     *
     * @return string
     */
    public function generateUniqueVersion(string $prefix): string
    {
        return $prefix.((new \DateTime())->getTimestamp() + $this::$VersionCorrector++);
    }

    /**
     * Method returns unique string
     *
     * @param string $prefix
     *
     * @return string
     */
    public function uniqid(string $prefix): string
    {
        return uniqid($prefix, true);
    }
}
