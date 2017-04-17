<?php

namespace Miky\Bundle\UserBundle\Entity;
use Miky\Bundle\AdBundle\Entity\Ad;


use Miky\Bundle\UserBundle\Model\UserReportInterface;
use Miky\Component\Core\Model\CommonModelInterface;
use Miky\Component\Core\Model\CommonModelTrait;
use Miky\Component\Resource\Model\ResourceInterface;

/**
 * UserReport
 */
class UserReport implements UserReportInterface, CommonModelInterface, ResourceInterface
{
    Use CommonModelTrait;


    /**
     * @var int
     */
    private $id;

    /**
     * @var Customer
     */
    private $whistleblower;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var Customer
     */
    private $user;

    /**
     * @var Ad
     */
    private $ad;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $body;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Customer
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Customer $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Ad
     */
    public function getAd()
    {
        return $this->ad;
    }

    /**
     * @param Ad $ad
     */
    public function setAd($ad)
    {
        $this->ad = $ad;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return Customer
     */
    public function getWhistleblower()
    {
        return $this->whistleblower;
    }

    /**
     * @param Customer $whistleblower
     */
    public function setWhistleblower($whistleblower)
    {
        $this->whistleblower = $whistleblower;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }



}
