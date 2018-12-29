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

use FTD\SaasBundle\Entity\Account;
use FTD\SaasBundle\Manager\AccountManagerInterface;
use FTD\SaasBundle\Types\PasswordType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * The form class to for creating a new account (User-entity).
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class AccountType extends BaseType
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
            ->add('email', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('data_class', $this->accountManager->getClass());
        $resolver->setDefault('constraints', [
            new UniqueEntity(['email']),
        ]);
    }
}
