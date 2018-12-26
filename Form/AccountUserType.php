<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

/**
 * The form class to for creating a new user from the logged in account.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class AccountUserType extends UserType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('email');
    }
}
