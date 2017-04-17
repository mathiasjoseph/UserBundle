<?php

namespace Miky\Bundle\UserBundle\Entity;
use Miky\Bundle\AdBundle\Entity\Ad;
use Miky\Bundle\AdBundle\Model\AdSearch;


use Miky\Bundle\UserBundle\Model\HistoryInterface;
use Miky\Component\Core\Model\CommonModelInterface;
use Miky\Component\Core\Model\CommonModelTrait;

/**
 * History
 */
class History implements HistoryInterface, CommonModelInterface
{

    Use CommonModelTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var Customer
     */
    protected $user;

    /**
     * @var Ad
     */
    protected $ad;

    /**
     * @var Customer
     */
    protected $profile;

    /**
     * @var int
     */
    protected $type;



    /**
     * @var AdSearch
     */
    protected $adSearch;



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
     * @return Customer
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param Customer $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }



    /**
     * @return AdSearch
     */
    public function getAdSearch()
    {
        return $this->adSearch;
    }

    /**
     * @param AdSearch $adSearch
     */
    public function setAdSearch($adSearch)
    {
        $this->adSearch = $adSearch;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


}
