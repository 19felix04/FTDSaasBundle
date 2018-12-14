<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Tests\EventListener;

use FTD\SaasBundle\Event\UserEvent;
use FTD\SaasBundle\EventListener\AccountCreateMailingListener;
use FTD\SaasBundle\FTDSaasBundleEvents;
use FTD\SaasBundle\Service\Mailer;
use FTD\SaasBundle\Tests\TestUser;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class AccountCreateMailingListenerTest extends TestCase
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
            [FTDSaasBundleEvents::ACCOUNT_CREATE => 'sendAccountCreateMail'],
            AccountCreateMailingListener::getSubscribedEvents()
        );
        $this->assertSame(1, $this->count(AccountCreateMailingListener::getSubscribedEvents()));
    }

    public function testSendAccountCreateMail()
    {
        $user = new TestUser();
        $user->setId(14);
        $user->setEmail('test@local.de');

        $this->mailer = $this->createMock(Mailer::class);
        $this->mailer->expects($this->once())->method('sendMail')->willReturn(true);

        $accountCreatingMailingListener = new AccountCreateMailingListener(
            $this->mailer,
            $this->twigEnvironment,
            $this->translator,
            'template.html.twig'
        );

        $this->assertTrue($accountCreatingMailingListener->sendAccountCreateMail(new UserEvent($user)));
    }
}
