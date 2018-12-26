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
use FTD\SaasBundle\Tests\Form\ValidatorExtensionTypeTestCase;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class PasswordResetTypeTest extends ValidatorExtensionTypeTestCase
{
    public function testSubmitValidData()
    {
        $account = new Account();
        $account->setPlainPassword('hans.zimmer');

        $formData = [
            'plainPassword' => 'hans.zimmer',
        ];

        $objectToCompare = new Account();
        $form = $this->factory->create(PasswordResetType::class, $objectToCompare);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->isValid());
        $this->assertSame($account->getEmail(), $objectToCompare->getEmail());
    }
}
