<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Service\Request;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\View\View;
use FTD\SaasBundle\Manager\BaseEntityManager;
use FTD\SaasBundle\Model\ApiHistoryResource;
use FTD\SaasBundle\Model\ApiResource;
use FTD\SaasBundle\Repository\ApiResourceRepositoryInterface;
use FTD\SaasBundle\Service\Authentication;
use FTD\SaasBundle\Service\Paginator;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * The class is a standard set of functions which can be used in endpoint-controllers to handle listing and updating of
 * entities.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class CRUDHandler
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var FilterBuilderUpdaterInterface
     */
    private $filterBuilderUpdater;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * Constructor with injecting services for generating forms, dispatching events, filter and paginate results.
     *
     * @param FormFactoryInterface          $formFactory
     * @param EventDispatcherInterface      $eventDispatcher
     * @param FilterBuilderUpdaterInterface $filterBuilderUpdater
     * @param RequestStack                  $requestStack
     * @param Paginator                     $paginator
     * @param Authentication                $authentication
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        EventDispatcherInterface $eventDispatcher,
        FilterBuilderUpdaterInterface $filterBuilderUpdater,
        RequestStack $requestStack,
        Paginator $paginator,
        Authentication $authentication
    ) {
        $this->formFactory = $formFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->filterBuilderUpdater = $filterBuilderUpdater;
        $this->requestStack = $requestStack;
        $this->paginator = $paginator;
        $this->authentication = $authentication;
    }

    /**
     * @param QueryBuilder            $queryBuilder
     * @param string                  $filterFormClass
     * @param ServiceEntityRepository $serviceEntityRepository
     *
     * @return View
     */
    public function handleFilterRequest(
        QueryBuilder $queryBuilder,
        string $filterFormClass,
        ServiceEntityRepository $serviceEntityRepository
    ) {
        $form = $this->formFactory->create($filterFormClass);
        $form->submit($this->requestStack->getCurrentRequest()->query->all());

        $orderByField = $this->requestStack->getMasterRequest()->query->get('orderBy', null);
        $orderByDirection = $this->requestStack->getMasterRequest()->query->get('order', null);

        if (
            $serviceEntityRepository instanceof ApiResourceRepositoryInterface
            && null !== $orderByField
            && in_array($orderByField, $serviceEntityRepository->getSortableFields())
            && null !== $orderByDirection
            && in_array($orderByDirection, ['ASC', 'DESC'])
        ) {
            $queryBuilder->orderBy($queryBuilder->getRootAliases()[0].'.'.$orderByField, $orderByDirection);
        }

        $this->filterBuilderUpdater->addFilterConditions($form, $queryBuilder);

        return View::create($this->paginator->paginate($queryBuilder));
    }

    /**
     * @param mixed             $entity
     * @param BaseEntityManager $baseEntityManager
     * @param string            $formName
     * @param string            $responseKey
     * @param int               $successStatusCode
     * @param string            $eventName
     * @param Event|null        $entityEvent
     *
     * @return View
     */
    public function handleUpdateRequest(
        $entity,
        BaseEntityManager $baseEntityManager,
        string $formName,
        string $responseKey,
        int $successStatusCode = Response::HTTP_OK,
        string $eventName = '',
        Event $entityEvent = null
    ) {
        $oldEntityVersion = null;
        if ($entity instanceof ApiHistoryResource) {
            $oldEntityVersion = clone $entity;
            $oldEntityVersion->setHistoryParent($entity);
        }

        $form = $this->formFactory->create($formName, $entity);
        $form->submit($this->requestStack->getMasterRequest()->request->all());

        if ($entity instanceof ApiResource) {
            /*
             * @var ApiResource
             */
            if (null === $entity->getId() && !$entity->checkUserCanCreate($this->authentication->getUser())) {
                throw new AccessDeniedHttpException(
                    sprintf(
                        'User not able to create entity of class %s',
                        \get_class($entity)
                    )
                );
            }

            if (null !== $entity->getId() && !$entity->checkUserCanEdit($this->authentication->getUser())) {
                throw new AccessDeniedHttpException(
                    sprintf(
                        'User not able to edit %s with id %s',
                        \get_class($entity),
                        $entity->getId()
                    )
                );
            }
        }

        if ($form->isValid()) {
            if ($oldEntityVersion instanceof ApiHistoryResource) {
                $baseEntityManager->update($oldEntityVersion);
                $entity->addHistoryChild($oldEntityVersion);
            }
            $baseEntityManager->update($entity);

            if ($entityEvent) {
                $this->eventDispatcher->dispatch($eventName, $entityEvent);
            }

            return View::create([$responseKey => $entity], $successStatusCode);
        }

        return View::create(['form' => $form], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param ApiResource       $entity
     * @param BaseEntityManager $baseEntityManager
     * @param int               $successStatusCode
     * @param string            $eventName
     * @param Event|null        $entityEvent
     *
     * @return View
     */
    public function handleRemoveRequest(
        ApiResource $entity,
        BaseEntityManager $baseEntityManager,
        int $successStatusCode = Response::HTTP_OK,
        string $eventName = '',
        Event $entityEvent = null
    ) {
        if (!$entity->checkUserCanDelete($this->authentication->getUser())) {
            throw new AccessDeniedHttpException(
                sprintf(
                    'User not able to remove %s with id %s',
                    \get_class($entity),
                    $entity->getId()
                )
            );
        }
        $baseEntityManager->remove($entity);

        if ($entityEvent) {
            $this->eventDispatcher->dispatch($eventName, $entityEvent);
        }

        return View::create([], $successStatusCode);
    }
}
