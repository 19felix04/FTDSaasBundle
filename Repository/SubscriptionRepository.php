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
use Doctrine\Common\Persistence\ManagerRegistry;
use FTD\SaasBundle\Entity\Account;
use FTD\SaasBundle\Entity\Subscription;

/**
 * @method Subscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscription[]    findAll()
 * @method Subscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    /**
     * @param Account $account
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilderFindByAccount(Account $account)
    {
        $qb = $this->createQueryBuilder('subscription');
        $qb->select('subscription')
            ->leftJoin('subscription.users', 'user')
            ->leftJoin('user.account', 'account')
            ->where($qb->expr()->eq('account.id', $account->getId()))
        ;

        return $qb;
    }

    /**
     * @param Account $account
     *
     * @return Subscription[]
     */
    public function findByAccount(Account $account)
    {
        return $this->getQueryBuilderFindByAccount($account)->getQuery()->getResult();
    }
}
