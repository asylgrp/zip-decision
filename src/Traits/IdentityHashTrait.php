<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision\Traits;

/**
 * Implementation of the Identity interface using a hash as id
 */
trait IdentityHashTrait
{
    /**
     * @var string
     */
    private $hash;

    /**
     * Get string to hash when creating id
     */
    abstract protected function getHashable(): string;

    public function getId(): string
    {
        if (!isset($this->hash)) {
            $this->hash = md5($this->getHashable());
        }

        return $this->hash;
    }

    protected function setId(string $hash): void
    {
        $this->hash = $hash;
    }
}
