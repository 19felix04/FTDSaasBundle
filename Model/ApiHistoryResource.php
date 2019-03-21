<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as JMS;

/**
 * An API-Resource, which contains history objects, should extend from this class.
 *
 * @JMS\ExclusionPolicy("all")
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
abstract class ApiHistoryResource extends ApiResource
{
    /**
     * @var self
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail"})
     */
    protected $historyParent;

    /**
     * @var self[]|ArrayCollection
     *
     * @JMS\Expose()
     * @JMS\Groups({"detail"})
     */
    protected $historyChildren;

    public function __construct()
    {
        $this->historyChildren = new ArrayCollection();
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\Groups({"detail", "list"})
     */
    public function getLastEditedAt()
    {
        if ($this->historyChildren->count() > 0) {
            return $this->historyChildren->first()->getCreatedAt();
        }

        return $this->getCreatedAt();
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\Groups({"detail", "list"})
     */
    public function getLastEditedBy()
    {
        if ($this->historyChildren->count() > 0) {
            return $this->historyChildren->first()->getCreatedBy();
        }

        return $this->getCreatedBy();
    }

    /**
     * @return ApiHistoryResource
     */
    public function getHistoryParent(): ?ApiHistoryResource
    {
        return $this->historyParent;
    }

    /**
     * @param self|null $historyParent
     *
     * @return ApiHistoryResource
     */
    public function setHistoryParent(?ApiHistoryResource $historyParent): ?ApiHistoryResource
    {
        $this->historyParent = $historyParent;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getHistoryChildren(): Collection
    {
        return $this->historyChildren;
    }

    public function addHistoryChild(ApiHistoryResource $historyChild): self
    {
        if (!$this->historyChildren->contains($historyChild)) {
            $this->historyChildren[] = $historyChild;
            $historyChild->setHistoryParent($this);
        }

        return $this;
    }
}
