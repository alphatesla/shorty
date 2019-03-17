<?php

namespace Allĥat\Bundle\ShortyBundle\Repository;

use Allĥat\Bundle\ShortyBundle\Entity\ShortyEntity;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * ShortyRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShortyRepository extends EntityRepository
{
    /**
     * [persist description]
     * @param  ShortyEntity $shortyEntity [description]
     * @return [type]                     [description]
     */
    public function persist(ShortyEntity $shortyEntity)
    {
        $this->_em->persist($shortyEntity);
    }


    /**
     * persists links in db
     *
     * @param  ShortyEntity $short [description]
     * @return [type]                [description]
     */
    public function save()
    {
        try {
            $this->_em->flush();

            return true;
        } catch (UniqueConstraintViolationException $e) {
            return false;
        }
    }


    /**
     * [findLast description]
     * @return [type] [description]
     */
    public function findLast()
    {
        $query = $this->createQueryBuilder('sg');
        $query->select('sg');
        $query->setMaxResults(1);
        $query->orderBy('sg.id', 'DESC');

        return $query->getQuery()->getResult()[0];
    }

    /**
     * [getUnusedOne description]
     * @return [type] [description]
     */
    public function findUnusedOne()
    {
        return $this->findOneBy(['is_used' => false]);
    }
}

