<?php

namespace Tests\Allĥat\Bundle\ShortyBundle\Repository;

use Allĥat\Bundle\ShortyBundle\Entity\ShortyEntity;
use Allĥat\Bundle\ShortyBundle\Repository\ShortyRepository;
use Doctrine\DBAL\Driver\DriverException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\UnitOfWork;
use Doctrine\ORM\Persisters\Entity\BasicEntityPersister;

class ShortyRepositoryTest extends \PHPUnit\Framework\TestCase
{
    private $em;
    private $unitOfWork;
    private $persister;
    private $meta;
    private $repository;

    public function setUp()
    {

        $this->entityReposity = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneBy'])
            ->getMock();

        $this->em = $this->getMockBuilder(EntityManager::class)
             ->disableOriginalConstructor()
             ->setMethods(['persist', 'flush', 'getUnitOfWork'])
             ->getMock();

        $this->unitOfWork = $this->getMockBuilder(UnitOfWork::class)
            ->disableOriginalConstructor()
            ->setMethods(['getEntityPersister'])
            ->getMock();

        $this->persister = $this->getMockBuilder(BasicEntityPersister::class)
            ->disableOriginalConstructor()
            -> setMethods(['load'])
            ->getMock();

        $this->unitOfWork->expects($this->any())
            ->method('getEntityPersister')
            ->willReturn($this->persister);

        $this->persister->expects($this->any())
            ->method('load')
            ->willReturn($this->entityReposity);


        $this->em->expects($this->any())
            ->method('getUnitOfWork')
            ->willReturn($this->unitOfWork);

        $this->meta = $this->getMockBuilder(ClassMetadata::class)
             ->disableOriginalConstructor()
             ->getMock();


        $this->repository = new ShortyRepository($this->em, $this->meta);
    }

    public function testSave()
    {

        $this->em->expects($this->once())
            ->method('flush');

        $result = $this->repository->save();
        $this->assertTrue($result);
    }


    public function testFindLast()
    {
        $this->markTestSkipped('TODO');
        $this->entityReposity->expects($this->once())
            ->method('createQueryBuilder');


        $this->repository->findLast();
    }

    public function testFindUnusedOne()
    {
        $this->markTestSkipped('TODO');
        $this->entityReposity->expects($this->once())
            ->method('findOneBy')
            ->with(['is_used' => false]);

        $this->repository->findUnusedOne();
    }
}
