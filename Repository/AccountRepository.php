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
use Doctrine\ORM\NonUniqueResultException;
use FTD\SaasBundle\Entity\Account;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    /**
     * {@inheritdoc}
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Account::class);
    }

    /**
     * @param string $confirmationToken
     *
     * @return null|Account
     */
    public function findByConfirmationToken(?string $confirmationToken)
    {
        $qb = $this->createQueryBuilder('account');
        $qb->where('account.confirmationToken = :confirmationToken')
            ->setParameter('confirmationToken', $confirmationToken);

        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $nonUniqueResultException) {
            // Not possible cause database constraint
            return null;
        }
    }
}
