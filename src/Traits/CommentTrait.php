<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision\Traits;

/**
 * Implementation of the Comment interface
 */
trait CommentTrait
{
    /**
     * @var string
     */
    private $comment = '';

    public function getComment(): string
    {
        return $this->comment;
    }

    protected function setComment(string $comment = ''): void
    {
        $this->comment = $comment;
    }
}
