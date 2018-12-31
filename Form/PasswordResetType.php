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

use FTD\SaasBundle\Manager\AccountManagerInterface;
use FTD\SaasBundle\Types\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The class builds the form to reset the user password.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class PasswordResetType extends BaseType
{
    /**
     * @var AccountManagerInterface
     */
    private $accountManager;

    /**
     * @param AccountManagerInterface $accountManager
     */
    public function __construct(AccountManagerInterface $accountManager)
    {
        $this->accountManager = $accountManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', PasswordType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('data_class', $this->accountManager->getClass());
    }
}
