<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 22/09/16
 * Time: 17:55
 */

namespace Miky\Bundle\UserBundle\Event;


use Miky\Bundle\UserBundle\Entity\CertificationRequest;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class CertificationEvent extends Event
{
    /**
     * @var null|Request
     */
    protected $request;
    /**
     * @var CertificationRequest
     */
    protected $certificationRequest;

    /**
     * CertificationEvent constructor.
     *
     * @param CertificationRequest $certification
     * @param Request|null $request
     */
    public function __construct(CertificationRequest $certificationRequest, Request $request = null)
    {
        $this->certificationRequest = $certificationRequest;
        $this->request = $request;
    }

    /**
     * @return CertificationRequest
     */
    public function getCertificationRequest()
    {
        return $this->certificationRequest;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

}