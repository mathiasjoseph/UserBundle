<?php

namespace Miky\Bundle\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Miky\Bundle\CommentBundle\Model\CommentInterface;
use Miky\Bundle\LocationBundle\Entity\Location;
use Miky\Bundle\MediaBundle\Model\MediaInterface;
use Miky\Bundle\UserBundle\Model\Customer as BaseCustomer;
use Miky\Component\Core\Model\CommonModelInterface;
use Miky\Component\Core\Model\CommonModelTrait;
use Miky\Component\Resource\Model\ResourceInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Customer
 * @ExclusionPolicy("all")
 */
class Customer extends BaseCustomer implements CommonModelInterface, ResourceInterface
{
    Use CommonModelTrait;

    /**
     * @var int
     * @Expose
     */
    protected $id;

    /**
     *  @Expose
     */
    protected $email;

    /**
     *  @Expose
     */
    protected $certified;

    /**
     * @var array
     * @Expose
     */
    protected $languagesSpoken;

    /**
     * @var string
     */
    protected $activity;


    protected $lastname;

    protected $firstname;


    /**
     * @var UserPreference
     */
    protected $preference;


    /**
     * @var string
     */
    protected $companyName;

    /**
     * @var string
     */
    protected $companyId;

    /**
     * @var string
     * @Assert\Length(max=850, maxMessage="Le description ne doit pas dépasser 850 caractères")
     */
    protected $companyDescription;

    /**
     * @var string
     */
    protected $facebookId;

    /**
     * @var string
     */
    protected $googleId;

    /**
     * @var string
     */
    protected $twitterId;

    /**
     * @var ArrayCollection
     */
    protected $ads;

    /**
     * @var MediaInterface
     */
    protected $profileImage;

    /**
     * @var string
     */
    protected $twitter;

    /**
     * @var string
     */
    protected $facebook;

    /**
     * @var string
     */
    protected $linkedin;

    /**
     * @var string
     */
    protected $phone;
    
    /**
     * @var string
     */
    protected $googleplus;

    /**
     * @var string
     */
    protected $mobile;

    /**
     * @var array
     */
    protected $favoriteAds;


    /**
     * @var History[]
     */
    protected $history;

    protected $location;

    /**
     * @var Location
     */
    protected $preferedLocation;




    /**
     * Customer constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->preference = new UserPreference();
        $this->preference->setCustomer($this);
    }


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
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return Customer
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set twitterId
     *
     * @param string $twitterId
     *
     * @return Customer
     */
    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;

        return $this;
    }

    /**
     * Get twitterId
     *
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     *
     * @return Customer
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     *
     * @return Customer
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     *
     * @return Customer
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     *
     * @return Customer
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return Customer
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set googleplus
     *
     * @param string $googleplus
     *
     * @return Customer
     */
    public function setGoogleplus($googleplus)
    {
        $this->googleplus = $googleplus;

        return $this;
    }

    /**
     * Get googleplus
     *
     * @return string
     */
    public function getGoogleplus()
    {
        return $this->googleplus;
    }


    /**
     * Set profileImage
     *
     * @param \Miky\Bundle\MediaBundle\Entity\Media $profileImage
     *
     * @return Customer
     */
    public function setProfileImage(\Miky\Bundle\MediaBundle\Entity\Media $profileImage = null)
    {
        $this->profileImage = $profileImage;

        return $this;
    }

    /**
     * Get profileImage
     *
     * @return \Miky\Bundle\MediaBundle\Entity\Media
     */
    public function getProfileImage()
    {
        return $this->profileImage;
    }

    /**
     * Add ad
     *
     * @param \Miky\Bundle\AdBundle\Entity\Ad $ad
     *
     * @return Customer
     */
    public function addAd(\Miky\Bundle\AdBundle\Entity\Ad $ad)
    {
        $this->ads[] = $ad;

        return $this;
    }

    /**
     * Remove ad
     *
     * @param \Miky\Bundle\AdBundle\Entity\Ad $ad
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAd(\Miky\Bundle\AdBundle\Entity\Ad $ad)
    {
        return $this->ads->removeElement($ad);
    }

    /**
     * Get ads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAds()
    {
        return $this->ads;
    }



    /**
     * Add favoriteAd
     *
     * @param \Miky\Bundle\AdBundle\Entity\Ad $favoriteAd
     *
     * @return Customer
     */
    public function addFavoriteAd(\Miky\Bundle\AdBundle\Entity\Ad $favoriteAd)
    {
        $this->favoriteAds[] = $favoriteAd;

        return $this;
    }

    /**
     * Remove favoriteAd
     *
     * @param \Miky\Bundle\AdBundle\Entity\Ad $favoriteAd
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFavoriteAd(\Miky\Bundle\AdBundle\Entity\Ad $favoriteAd)
    {
        return $this->favoriteAds->removeElement($favoriteAd);
    }

    /**
     * Get favoriteAds
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavoriteAds()
    {
        return $this->favoriteAds;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }


    /**
     * Add history
     *
     * @param \Miky\Bundle\UserBundle\Entity\History $history
     *
     * @return Customer
     */
    public function addHistory(\Miky\Bundle\UserBundle\Entity\History $history)
    {
        $this->history[] = $history;

        return $this;
    }

    /**
     * Remove history
     *
     * @param \Miky\Bundle\UserBundle\Entity\History $history
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeHistory(\Miky\Bundle\UserBundle\Entity\History $history)
    {
        return $this->history->removeElement($history);
    }

    /**
     * Get history
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Set preference
     *
     * @param \Miky\Bundle\UserBundle\Entity\UserPreference $preference
     *
     * @return Customer
     */
    public function setPreference(\Miky\Bundle\UserBundle\Entity\UserPreference $preference = null)
    {
        if ($preference == null){
            $preference = new UserPreference();
        }else{
        $this->preference = $preference;
        }

        return $this;
    }

    /**
     * Get preference
     *
     * @return \Miky\Bundle\UserBundle\Entity\UserPreference
     */
    public function getPreference()
    {
        if ($this->preference == null){
            return new UserPreference();
        }else{
            return $this->preference;
        }
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     *
     * @return Customer
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param Location $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
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
     * @return string
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param string $companyId
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
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

    /**
     * @return Location
     */
    public function getPreferedLocation()
    {
        return $this->preferedLocation;
    }

    /**
     * @param Location $preferedLocation
     */
    public function setPreferedLocation($preferedLocation)
    {
        $this->preferedLocation = $preferedLocation;
    }

    /**
     * @return array
     */
    public function getLanguagesSpoken()
    {
        return $this->languagesSpoken;
    }

    /**
     * @param array $languagesSpoken
     */
    public function setLanguagesSpoken($languagesSpoken)
    {
        $this->languagesSpoken = $languagesSpoken;
    }


}
