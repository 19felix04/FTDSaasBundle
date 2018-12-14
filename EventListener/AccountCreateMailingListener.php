<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\EventListener;

use FTD\SaasBundle\Event\UserEvent;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Service\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * The class listen to events and send the account creating mail.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class AccountCreateMailingListener implements EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment
     */
    protected $twigEnvironment;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $templateAccountCreate;

    /**
     * PasswordForgetMailer constructor.
     *
     * @param Mailer              $mailer
     * @param \Twig_Environment   $twigEnvironment
     * @param TranslatorInterface $translator
     * @param string              $templateAccountCreate
     */
    public function __construct(
        Mailer $mailer,
        \Twig_Environment $twigEnvironment,
        TranslatorInterface $translator,
        string $templateAccountCreate
    ) {
        $this->mailer = $mailer;
        $this->twigEnvironment = $twigEnvironment;
        $this->translator = $translator;
        $this->templateAccountCreate = $templateAccountCreate;
    }

    public static function getSubscribedEvents()
    {
        return [
            FTDSaasBundleEvents::ACCOUNT_CREATE => 'sendAccountCreateMail',
        ];
    }

    /**
     * @param UserEvent $userEvent
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @return bool
     */
    public function sendAccountCreateMail(UserEvent $userEvent)
    {
        if (
            0 === strlen($this->templateAccountCreate)
            || 'false' === $this->templateAccountCreate
        ) {
            return;
        }

        $content = $this->twigEnvironment->render(
            $this->templateAccountCreate, ['user' => $userEvent->getUser()]
        );

        return $this->mailer->sendMail(
            $userEvent->getUser()->getEmail(),
            $this->translator->trans('mail.subject.accountCreate', [], 'ftd_saas'),
            $content
        );
    }
}
