<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

/**
 * Container that wrapps a value with dates and a comment
 */
class DataWrapper implements DateableInterface, CommentInterface
{
    use Traits\DateableTrait, Traits\CommentTrait;

    /**
     * @var string
     */
    private $value;

    public function __construct(string $value, string $comment = '', \DateTimeImmutable $updated = null)
    {
        $this->value = $value;
        $this->setComment($comment);
        $this->setCreated($updated);
        $this->setUpdated($updated);
    }

    /**
     * Get wrapped value
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get value is string
     */
    public function __toString(): string
    {
        return $this->getValue();
    }
}
