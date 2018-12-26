<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Tests\EventListener\Account;

use FTD\SaasBundle\Entity\Account;
use FTD\SaasBundle\Event\AccountEvent;
use FTD\SaasBundle\EventListener\Account\PasswordForgetMailingListener;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Service\Mailer;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class PasswordForgetMailingListenerTest extends TestCase
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var \Twig_Environment
     */
    private $twigEnvironment;

    /**
     * @var Mailer
     */
    private $mailer;

    public function setUp()
    {
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->translator->method('trans')->willReturn('mailSubject');

        $this->twigEnvironment = $this->createMock(\Twig_Environment::class);
        $this->twigEnvironment->method('render')->willReturn('renderedContent');
    }

    public function testGetSubscribedEvents()
    {
        $this->assertArraySubset(
            [FTDSaasBundleEvents::ACCOUNT_PASSWORD_RESET => 'sendPasswordForgetMail'],
            PasswordForgetMailingListener::getSubscribedEvents()
        );
        $this->assertSame(1, $this->count(PasswordForgetMailingListener::getSubscribedEvents()));
    }

    public function testSendPasswordForgetMail()
    {
        $account = new Account();
        $account->setEmail('test@local.de');

        $this->mailer = $this->createMock(Mailer::class);
        $this->mailer->expects($this->once())->method('sendMail')->willReturn(true);

        $passwordForgetMailingListener = new PasswordForgetMailingListener(
            $this->mailer,
            $this->twigEnvironment,
            $this->translator,
            'passwordForgetTemplate'
        );

        $this->assertTrue($passwordForgetMailingListener->sendPasswordForgetMail(new AccountEvent($account)));
    }
}
