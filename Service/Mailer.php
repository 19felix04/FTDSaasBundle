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

/**
 * The class is able to send custom mails.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    protected $swiftMailer;

    /**
     * @var string
     */
    private $mailerAddress;

    /**
     * @var string
     */
    private $mailerSenderName;

    /**
     * Constructor with injecting SwiftMailer and mail-header-data.
     *
     * @param \Swift_Mailer $swiftMailer
     * @param string        $mailerAddress
     * @param string        $mailerSenderName
     */
    public function __construct(
        \Swift_Mailer $swiftMailer,
        string $mailerAddress,
        string $mailerSenderName
    ) {
        $this->swiftMailer = $swiftMailer;
        $this->mailerAddress = $mailerAddress;
        $this->mailerSenderName = $mailerSenderName;
    }

    /**
     * @param string $receiver
     * @param string $subject
     * @param string $content
     *
     * @return bool
     */
    public function sendMail($receiver, $subject, $content)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom([$this->mailerAddress => $this->mailerSenderName])
            ->setTo([$receiver])
            ->setBody($content);

        return (bool) $this->swiftMailer->send($message);
    }
}
