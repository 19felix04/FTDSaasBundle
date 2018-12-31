<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use FTD\SaasBundle\Entity\User;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements ApiResourceRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getSortableFields()
    {
        return ['username'];
    }

    /**
     * {@inheritdoc}
     */
    public function getStandardSortField()
    {
        return 'username';
    }

    /**
     * {@inheritdoc}
     */
    public function getStandardSortDirection()
    {
        return 'DESC';
    }

    /**
     * @param string $alias
     * @param null   $indexBy
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        $qb = parent::createQueryBuilder($alias, $indexBy);

        return $qb->orderBy($alias . '.username', 'ASC');
    }
}
