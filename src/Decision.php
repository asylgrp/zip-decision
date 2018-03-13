<?php

declare(strict_types = 1);

namespace workbenchapp\zipdecision;

use byrokrat\amount\Amount;

/**
 * Decision value object
 */
class Decision implements IdentityInterface, DateableInterface, CommentInterface
{
    use Traits\DateableTrait, Traits\CommentTrait;

    /**
     * @var string
     */
    private $id;

    /**
     * @var ClaimArray Loaded claims
     */
    private $claims;

    /**
     * @var Amount Availiable funds before allocation
     */
    private $fundsPre;

    /**
     * @var Amount Availiable funds after allocation
     */
    private $fundsPost;

    /**
     * @var Amount Ratio used when allocating
     */
    private $ratio;

    /**
     * @var Amount Guarantee used when allocating
     */
    private $guarantee;

    public function __construct(
        \DateTimeImmutable $created,
        string $id,
        ClaimArray $claims,
        Amount $fundsPre,
        Amount $fundsPost,
        Amount $ratio,
        Amount $guarantee,
        string $comment = ''
    ) {
        $this->setCreated($created);
        $this->setUpdated($created);
        $this->id = $id;
        $this->claims = $claims;
        $this->fundsPre = $fundsPre;
        $this->fundsPost = $fundsPost;
        $this->ratio = $ratio;
        $this->guarantee = $guarantee;
        $this->setComment($comment);
    }

    /**
     * @deprecated Use getCreated() instead
     */
    public function getDate(): \DateTimeImmutable
    {
        trigger_error('Deprecated, use getCreated() instead', E_USER_DEPRECATED);
        return $this->getCreated();
    }

    /**
     * Get string identifying this decision
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @deprecated Use getId() instead
     */
    public function getHash(): string
    {
        trigger_error('Deprecated, use getId() instead', E_USER_DEPRECATED);
        return $this->getId();
    }

    /**
     * Get registered claims
     */
    public function getClaims(): ClaimArray
    {
        return $this->claims;
    }

    /**
     * Get funds availiable before allocation
     */
    public function getFundsPre(): Amount
    {
        return $this->fundsPre;
    }

    /**
     * Get funds availiable after allocation
     */
    public function getFundsPost(): Amount
    {
        return $this->fundsPost;
    }

    /**
     * Get ratio used when allocating
     */
    public function getRatio(): Amount
    {
        return $this->ratio;
    }

    /**
     * Get guarantee used when allocating
     */
    public function getGuarantee(): Amount
    {
        return $this->guarantee;
    }
}
