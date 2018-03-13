<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision\Traits;

/**
 * Implementation of the DateableInterface
 */
trait DateableTrait
{
    /**
     * @var \DateTimeImmutable
     */
    private $created;

    /**
     * @var \DateTimeImmutable
     */
    private $updated;

    public function getCreated(): \DateTimeImmutable
    {
        if (!isset($this->created)) {
            $this->setCreated();
        }

        return $this->created;
    }

    public function getUpdated(): \DateTimeImmutable
    {
        if (!isset($this->updated)) {
            $this->setUpdated();
        }

        return $this->updated;
    }

    public function isOlderThan(\DateTimeInterface $date): bool
    {
        return $this->getCreated() < $date;
    }

    protected function setCreated(\DateTimeImmutable $created = null): void
    {
        $this->created = $created ?: new \DateTimeImmutable;
    }

    protected function setUpdated(\DateTimeImmutable $updated = null): void
    {
        $this->updated = $updated ?: $this->getCreated();
    }
}
