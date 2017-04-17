<?php

namespace Miky\Bundle\UserBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;


use Miky\Bundle\LocationBundle\Entity\Location;
use Miky\Bundle\MediaBundle\Model\MediaInterface;
use Miky\Bundle\OptionBundle\Entity\UserPackage;
use Miky\Component\Core\Model\CommonModelInterface;
use Miky\Component\Core\Model\CommonModelTrait;
use Miky\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CertificationRequest
 */
class CertificationRequest implements ResourceInterface, CommonModelInterface
{
    Use CommonModelTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    protected $activity;

    /**
     * @var Location
     */
    protected $location;

    /**
     * @var string
     */
    protected $companyId;

    /**
     * @var boolean
     */
    protected $paid;

    /**
     * @var string
     * @Assert\Length(max=20, maxMessage="Le nom ne doit pas dépasser 20 caractères")
     */
    protected $companyName;

    /**
     * @var string
     * @Assert\Length(max=850, maxMessage="Le description ne doit pas dépasser 850 caractères")
     */
    protected $companyDescription;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var UserPackage
     */
    protected $package;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var MediaInterface[]
     */
    protected $files;

    /**
     * CertificationRequest constructor.
     */
    public function __construct()
    {
        $this->paid = false;
        $this->files = new ArrayCollection();
    }


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
     * Set comment
     *
     * @param string $comment
     *
     * @return CertificationRequest
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set companyId
     *
     * @param string $companyId
     *
     * @return CertificationRequest
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get companyId
     *
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Set location
     *
     * @param \Miky\Bundle\LocationBundle\Entity\Location $location
     *
     * @return CertificationRequest
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

    /**
     * Set customer
     *
     * @param \Miky\Bundle\UserBundle\Entity\Customer $customer
     *
     * @return CertificationRequest
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
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getCompanyDescription()
    {
        return $this->companyDescription;
    }

    /**
     * @param string $companyDescription
     */
    public function setCompanyDescription($companyDescription)
    {
        $this->companyDescription = $companyDescription;
    }

    /**
     * @return UserPackage
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param UserPackage $package
     */
    public function setPackage($package)
    {
        $this->package = $package;
    }

    /**
     * @return boolean
     */
    public function isPaid()
    {
        return $this->paid;
    }

    /**
     * @param boolean $paid
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;
    }


    /**
     * Add file
     *
     * @param MediaInterface $file
     *
     * @return Ad
     */
    public function addFile($file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param MediaInterface $file
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFile(MediaInterface $file)
    {
        return $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param string $activity
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;
    }


}
