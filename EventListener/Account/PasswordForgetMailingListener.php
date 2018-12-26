<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\EventListener\Account;

use FTD\SaasBundle\Event\AccountEvent;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Service\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * The class listen to events and sends the password reset mail.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class PasswordForgetMailingListener implements EventSubscriberInterface
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
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var string
     */
    private $templatePasswordForget;

    /**
     * PasswordForgetMailer constructor.
     *
     * @param Mailer              $mailer
     * @param \Twig_Environment   $twigEnvironment
     * @param TranslatorInterface $translator
     * @param string              $templatePasswordForget
     */
    public function __construct(
        Mailer $mailer,
        \Twig_Environment $twigEnvironment,
        TranslatorInterface $translator,
        string $templatePasswordForget
    ) {
        $this->mailer = $mailer;
        $this->twigEnvironment = $twigEnvironment;
        $this->translator = $translator;
        $this->templatePasswordForget = $templatePasswordForget;
    }

    public static function getSubscribedEvents()
    {
        return [
            FTDSaasBundleEvents::ACCOUNT_PASSWORD_RESET => 'sendPasswordForgetMail',
        ];
    }

    /**
     * @param \FTD\SaasBundle\Event\AccountEvent $accountEvent
     *
     * @return bool If a mail is send true will returned.
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendPasswordForgetMail(AccountEvent $accountEvent)
    {
        if (
            0 === strlen($this->templatePasswordForget)
            || 'false' === $this->templatePasswordForget
        ) {
            return false;
        }

        $content = $this->twigEnvironment->render(
            $this->templatePasswordForget, ['account' => $accountEvent->getAccount()]
        );

        return (bool) $this->mailer->sendMail(
            $accountEvent->getAccount()->getEmail(),
            $this->translator->trans('mail.subject.passwordForget', [], 'ftd_saas'),
            $content
        );
    }
}
