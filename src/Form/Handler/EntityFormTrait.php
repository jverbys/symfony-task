<?php
namespace App\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

trait EntityFormTrait
{
    /**
     * @param FormInterface $form
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);

        return $form->isSubmitted() && $form->isValid();
    }

    /**
     * @param FormInterface $form
     * @return bool
     */
    public function formHasErrors(FormInterface $form)
    {
        return $form->isSubmitted() && 0 < count($form->getErrors(true));
    }
}
