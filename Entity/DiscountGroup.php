<?php

namespace Entity;

class DiscountGroup extends Entity implements EntityInterface
{
    protected $title;
    protected $discountPercent;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getDiscountPercent(): int
    {
        return $this->discountPercent;
    }

    /**
     * @param int $discountPercent
     * @return void
     */
    public function setDiscountPercent(int $discountPercent)
    {
        $this->discountPercent = $discountPercent;
    }
}