<?php

/*
 * This file is part of the FTDSaasBundle package.
 *
 * (c) Felix Niedballa <https://felixniedballa.de/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FTD\SaasBundle\Serializer;

use JMS\Serializer\Handler\FormErrorHandler as JMSFormErrorsHandler;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * The class renders a different view for form-errors.
 *
 * @author Felix Niedballa <schreib@felixniedballa.de>
 */
class FormErrorHandler extends JMSFormErrorsHandler
{
    /**
     * @var TranslatorInterface
     */
    private $translation;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translation = $translator;
        parent::__construct($translator);
    }

    /**
     * @param JsonSerializationVisitor $visitor
     * @param Form                     $form
     * @param array                    $type
     *
     * @return \ArrayObject
     */
    public function serializeFormToJson(JsonSerializationVisitor $visitor, Form $form, array $type)
    {
        return $this->convertToArray($visitor, $form);
    }

    /**
     * @param JsonSerializationVisitor $visitor
     * @param Form                     $data
     *
     * @return \ArrayObject
     */
    private function convertToArray(JsonSerializationVisitor $visitor, Form $data)
    {
        $isRoot = null === $visitor->getRoot();

        $form = new \ArrayObject();
        $errors = array();
        foreach ($data->getErrors() as $error) {
            $errors[] = $this->getMessageError($error);
        }

        if ($errors) {
            $form[] = $errors;
        }

        $children = array();

        foreach ($data->all() as $child) {
            if ($child instanceof Form) {
                if (isset($this->convertToArray($visitor, $child)[0])) {
                    $children[$child->getName()] = $this->convertToArray($visitor, $child)[0];
                }
            }
        }

        if ($children) {
            $form['errors'] = $children;
        }

        if ($isRoot) {
            $visitor->setRoot($form);
        }

        return $form;
    }

    /**
     * @param FormError $error
     *
     * @return string
     */
    private function getMessageError(FormError $error)
    {
        if (null !== $error->getMessagePluralization()) {
            return $this->translation->transChoice($error->getMessageTemplate(), $error->getMessagePluralization(), $error->getMessageParameters(), 'validators');
        }

        return $this->translation->trans($error->getMessageTemplate(), $error->getMessageParameters(), 'validators');
    }
}
