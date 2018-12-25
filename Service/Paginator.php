<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class Paginator
{
    const LIMIT = 10;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param EntityManagerInterface $entityManager
     * @param RequestStack           $requestStack
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ) {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param int|null     $maxLimit
     *
     * @return array
     */
    public function paginate(QueryBuilder $queryBuilder, $maxLimit = null)
    {
        $this->setLimit($maxLimit);

        $paginationData = [
            'limit' => $this->limit,
            'results' => $this->getResults($queryBuilder, $this->getCurrentPage()),
            'pages' => $this->getMaxPages($queryBuilder),
            'currentPage' => $this->getCurrentPage(),
            'query' => $queryBuilder->getQuery()->getDQL()
        ];

        return $paginationData;
    }

    public function getMaxPages(QueryBuilder $queryBuilder)
    {
        try {
            if ($this->limit > 0) {
                $queryBuilder
                    ->select($queryBuilder->expr()->count($queryBuilder->getRootAliases()[0]))
                    ->setMaxResults(null)->setFirstResult(0);

                return intval(ceil($queryBuilder->getQuery()->getSingleScalarResult() / $this->limit));
            }
        } catch (\Exception $exception) {
            return '-1';
        }
    }

    public function getResults(QueryBuilder $queryBuilder, $currentPage)
    {
        $firstResult = ($currentPage - 1) * $this->limit;
        $query = $queryBuilder->setFirstResult($firstResult)->setMaxResults($this->limit);

        return $query->getQuery()->getResult();
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return intval(
            $this->requestStack->getMasterRequest()->query->get('page', 1)
        );
    }

    /**
     * Calculates the max results per page.
     *
     * @param int $maxLimit
     */
    private function setLimit($maxLimit = null)
    {
        if (null === $maxLimit) {
            $maxLimit = 300;
        }

        if ($this->requestStack->getMasterRequest()->query->get('limit', false)) {
            $limitQuery = $this->requestStack->getMasterRequest()->query->get('limit', false);
            if ('-1' === $limitQuery || 0 === intval($limitQuery)) {
                $this->limit = $maxLimit;
            } elseif (intval($limitQuery) > $maxLimit) {
                $this->limit = $maxLimit;
            } else {
                $this->limit = intval($limitQuery);
            }
        } else {
            $this->limit = self::LIMIT;
        }
    }
}
