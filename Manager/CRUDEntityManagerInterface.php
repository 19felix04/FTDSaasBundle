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

/**
 * Base Manager to handle entities connected to database.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
interface CRUDEntityManagerInterface
{
    /**
     * The function saves the passing entity to database.
     *
     * @param mixed $entity
     * @param bool  $flush
     */
    public function update($entity, $flush = true): void;

    /**
     * The function removes the passing entity from database.
     *
     * @param mixed $entity
     * @param bool  $flush
     */
    public function remove($entity, $flush = true): void;
}
