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
use FTD\SaasBundle\Entity\Invitation;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Invitation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invitation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invitation[]    findAll()
 * @method Invitation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvitationRepository extends ServiceEntityRepository implements ApiResourceRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Invitation::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getSortableFields()
    {
        return ['email'];
    }

    /**
     * {@inheritdoc}
     */
    public function getStandardSortField()
    {
        return 'email';
    }

    /**
     * {@inheritdoc}
     */
    public function getStandardSortDirection()
    {
        return 'DESC';
    }
}
