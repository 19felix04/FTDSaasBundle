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
use FTD\SaasBundle\Form\UserType;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Manager\UserManager;
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
     * @var UserManager
     */
    private $userManager;

    /**
     * @param Authentication $authentication
     * @param CRUDHandler    $crudHandler
     * @param UserManager    $userManager
     */
    public function __construct(
        Authentication $authentication,
        CRUDHandler $crudHandler,
        UserManager $userManager
    ) {
        $this->authentication = $authentication;
        $this->crudHandler = $crudHandler;
        $this->userManager = $userManager;
    }

    /**
     * @return View
     *
     * @Rest\View(serializerGroups={"detail"})
     * @Rest\Get("users/me")
     */
    public function getMeAction()
    {
        if(($user = $this->authentication->getCurrentUser()) instanceof User) {
            return View::create(['user' => $this->authentication->getCurrentUser()]);
        }
        return View::create([], Response::HTTP_NOT_FOUND);
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
            UserType::class,
            'user',
            Response::HTTP_CREATED,
            FTDSaasBundleEvents::USER_CREATE,
            new UserEvent($user)
        );
    }
}
