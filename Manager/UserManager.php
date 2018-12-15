<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FTD\SaasBundle\Entity\User;
use FTD\SaasBundle\Repository\UserRepository;
use FTD\SaasBundle\Service\Authentication;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * The class UserManager manage the updating and finding of an user entity.
 *
 * @method UserRepository getRepository()
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class UserManager extends BaseEntityManager
{
    /**
     * @var UserPasswordEncoderInterface
     */
    protected $userPasswordEncoder;

    /**
     * @param EntityManagerInterface       $entityManager
     * @param Authentication               $authentication
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        Authentication $authentication,
        UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        parent::__construct($entityManager, $authentication);
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * The function removes the passing entity from database.
     *
     * @param mixed $entity
     * @param bool  $flush
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove($entity, $flush = true)
    {
        $this->entityManager->remove($entity);
        if ($flush) {
            $this->entityManager->flush();
        }
    }

    /**
     * @return User
     */
    public function create()
    {
        $user = new User();
        $user->setEnabled(true);

        return $user;
    }

    /**
     * The function saves the.
     *
     * @param User $user
     * @param bool $flush
     */
    public function update($user, $flush = true)
    {
        if (null != $user->getPlainPassword()) {
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword()));
        }

        parent::update($user, $flush);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function findUserByUsernameOrEmail($query)
    {
        return $this->getRepository()->loadUserByUsername($query);
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return User::class;
    }
}
