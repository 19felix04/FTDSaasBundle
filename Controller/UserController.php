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
use FTD\SaasBundle\Service\Authentication;

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
     * UserController constructor.
     *
     * @param Authentication $authentication
     */
    public function __construct(
        Authentication $authentication
    ) {
        $this->authentication = $authentication;
    }

    /**
     * @return View
     *
     * @Rest\View(serializerGroups={"detail"})
     * @Rest\Get("users/me")
     */
    public function getMeAction()
    {
        return View::create(['user' => $this->authentication->getUser()]);
    }
}
