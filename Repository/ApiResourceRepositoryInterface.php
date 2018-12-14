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

/**
 * The interface represents a standard repository for REST-Api-Resources.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
interface ApiResourceRepositoryInterface
{
    /**
     * @return array|string[]
     */
    public function getSortableFields();

    /**
     * @return string
     */
    public function getStandardSortField();

    /**
     * @return string
     */
    public function getStandardSortDirection();
}
