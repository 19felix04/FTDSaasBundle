<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Tests\Form;

use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class ValidatorExtensionTypeTestCase extends TypeTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->factory = Forms::createFormFactoryBuilder()
            ->addTypes($this->getTypes())
            ->addExtensions($this->getExtensions())
            ->addTypeExtensions($this->getTypeExtensions())
            ->getFormFactory();
        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }

    /**
     * @return array
     */
    protected function getTypes()
    {
        return array();
    }

    /**
     * @return array
     */
    protected function getTypeExtensions()
    {
        $validator = $this->getMockBuilder(ValidatorInterface::class)->getMock();
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));

        return array(
            new FormTypeValidatorExtension($validator),
        );
    }
}
