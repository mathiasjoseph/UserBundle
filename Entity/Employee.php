<?php

namespace Miky\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Model\ParticipantInterface;
use Miky\Bundle\AdBundle\Entity\Ad;


use Miky\Bundle\CommentBundle\Model\CommentInterface;
use Miky\Component\Media\Model\MediaInterface;
use Miky\Bundle\UserBundle\Model\Employee as BaseEmployee;
use Miky\Component\Core\Model\CommonModelTrait;
use Miky\Component\Resource\Model\ResourceInterface;

/**
 * Employee
 */
class Employee extends BaseEmployee  implements CommentInterface, ResourceInterface
{
    Use CommonModelTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Ad[]
     */
    protected $adsValidation;


    /**
     * @var MediaInterface
     */
    private $profileImage;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add adsValidation
     *
     * @param \Miky\Bundle\AdBundle\Entity\Ad $adsValidation
     *
     * @return Employee
     */
    public function addAdsValidation(\Miky\Bundle\AdBundle\Entity\Ad $adsValidation)
    {
        $this->adsValidation[] = $adsValidation;

        return $this;
    }

    /**
     * Remove adsValidation
     *
     * @param \Miky\Bundle\AdBundle\Entity\Ad $adsValidation
     */
    public function removeAdsValidation(\Miky\Bundle\AdBundle\Entity\Ad $adsValidation)
    {
        $this->adsValidation->removeElement($adsValidation);
    }

    /**
     * Get adsValidation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdsValidation()
    {
        return $this->adsValidation;
    }

    /**
     * @return MediaInterface
     */
    public function getProfileImage()
    {
        return $this->profileImage;
    }

    /**
     * @param MediaInterface $profileImage
     */
    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;
    }


}
