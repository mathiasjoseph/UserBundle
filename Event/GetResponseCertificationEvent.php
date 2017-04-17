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
use Symfony\Component\HttpFoundation\Response;

class GetResponseCertificationEvent extends Event
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
     * @var Response
     */
     protected $response;

    /**
     * CertificationEvent constructor.
     *
     * @param CertificationRequest $certification
     * @param Request|null $request
     */
    public function __construct(CertificationRequest $certificationRequest, Response $response, Request $request = null)
    {
        $this->certificationRequest = $certificationRequest;
        $this->request = $request;
        $this->response = $response;
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

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }



}