<?php
/**
 * Created by PhpStorm.
 * User: miky
 * Date: 26/10/16
 * Time: 10:14
 */

namespace Miky\Bundle\UserBundle\Manager;


use Doctrine\Common\Persistence\ObjectManager;
use Miky\Bundle\UserBundle\Entity\History;

class HistoryManager
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repository;

    /**
     * Constructor.
     * @param ObjectManager $om
     * @param string $class
     */
    public function __construct(ObjectManager $om, $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);
        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteHistory(History $history)
    {
        $this->objectManager->remove($history);
        $this->objectManager->flush();
    }

    public function getClass()
    {
        return $this->class;
    }

    public function findHistoricalBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * @param array $criteria
     * @return History|null
     */
    public function findOneHistoricalBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }


    public function updateHistory(History $history, $andFlush = true)
    {
        $this->objectManager->persist($history);
        if ($andFlush) {
            $this->objectManager->flush();
        }
    }

    /**
     * Returns an empty history instance
     *
     * @return History
     */
    public function createHistory()
    {
        $class = $this->getClass();
        $history = new $class;
        return $history;
    }



}