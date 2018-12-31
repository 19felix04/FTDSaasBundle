<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use FTD\SaasBundle\Entity\User;
use FTD\SaasBundle\Event\UserEvent;
use FTD\SaasBundle\Form\AccountUserType;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Manager\UserManagerInterface;
use FTD\SaasBundle\Service\Authentication;
use FTD\SaasBundle\Service\Request\CRUDHandler;
use Symfony\Component\HttpFoundation\Response;

/**
 * The class contains API-Endpoints to handle User-entities.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class UserController
{
    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var CRUDHandler
     */
    private $crudHandler;

    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * @var string
     */
    private $userTypeClass;

    /**
     * @var bool
     */
    private $settingsSoftwareAsAService;

    /**
     * @param Authentication       $authentication
     * @param CRUDHandler          $crudHandler
     * @param UserManagerInterface $userManager
     * @param string               $userTypeClass
     * @param bool                 $settingsSoftwareAsAService
     */
    public function __construct(
        Authentication $authentication,
        CRUDHandler $crudHandler,
        UserManagerInterface $userManager,
        string $userTypeClass,
        bool $settingsSoftwareAsAService
    ) {
        $this->authentication = $authentication;
        $this->crudHandler = $crudHandler;
        $this->userManager = $userManager;
        $this->userTypeClass = $userTypeClass;
        $this->settingsSoftwareAsAService = $settingsSoftwareAsAService;
    }

    /**
     * @return View
     *
     * @Rest\View(serializerGroups={"detail"})
     * @Rest\Get("users/me")
     */
    public function getMeAction()
    {
        if (($user = $this->authentication->getCurrentUser()) !== null) {
            return View::create(['user' => $user]);
        }

        return View::create([], Response::HTTP_NOT_FOUND);
    }

    /**
     * The endpoint contains logic to handle a new user creation.
     *
     * @return View
     *
     * @Rest\View(serializerGroups={"detail"})
     * @Rest\Post("users/me")
     */
    public function postMeAction()
    {
        if (false === $this->settingsSoftwareAsAService) {
            return View::create([], Response::HTTP_NOT_FOUND);
        }

        $account = $this->authentication->getCurrentAccount();

        $user = $this->userManager->create();
        $user->setEmail($account->getEmail());
        $user->setAccount($account);

        return $this->crudHandler->handleUpdateRequest(
            $user,
            $this->userManager,
            AccountUserType::class,
            'user',
            Response::HTTP_CREATED,
            FTDSaasBundleEvents::USER_CREATE,
            new UserEvent($user)
        );
    }

    /**
     * @return View
     *
     * @Rest\View(serializerGroups={"detail"})
     * @Rest\Post("users")
     */
    public function postUserAction()
    {
        $user = $this->userManager->create();

        return $this->crudHandler->handleUpdateRequest(
            $user,
            $this->userManager,
            $this->userTypeClass,
            'user',
            Response::HTTP_CREATED,
            FTDSaasBundleEvents::USER_CREATE,
            new UserEvent($user)
        );
    }
}
