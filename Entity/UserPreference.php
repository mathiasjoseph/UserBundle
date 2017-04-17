<?php

namespace Miky\Bundle\UserBundle\Entity;
use Miky\Bundle\LocationBundle\Entity\Location;

/**
 * UserPreference
 */
class UserPreference
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var Location
     */
    protected $location;


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
     * Set customer
     *
     * @param \Miky\Bundle\UserBundle\Entity\Customer $customer
     *
     * @return UserPreference
     */
    public function setCustomer(\Miky\Bundle\UserBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Miky\Bundle\UserBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set location
     *
     * @param \Miky\Bundle\LocationBundle\Entity\Location $location
     *
     * @return UserPreference
     */
    public function setLocation(\Miky\Bundle\LocationBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \Miky\Bundle\LocationBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }
}
