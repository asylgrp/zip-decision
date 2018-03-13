<?php

namespace workbenchapp\zipdecision;

/**
 * Defines an object containing dates
 */
interface DateableInterface
{
    /**
     * Get object creation date
     */
    public function getCreated(): \DateTimeImmutable;

    /**
     * Get object updated date
     */
    public function getUpdated(): \DateTimeImmutable;

    /**
     * Check if object is older than a certain date
     */
    public function isOlderThan(\DateTimeInterface $date): bool;
}
