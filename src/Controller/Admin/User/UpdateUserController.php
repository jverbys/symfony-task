<?php

namespace App\Controller\Admin\User;

use App\Entity\User;
use App\Enum\ResponseCodeEnum;
use App\Form\Handler\EntityFormTrait;
use App\Form\UserType;
use App\UseCase\User\UpdateUserUseCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UpdateUserController
 * @package App\Controller\Admin\User
 */
class UpdateUserController extends AbstractController
{
    use EntityFormTrait;

    /**
     * @Route("/{user}/edit", name="app_admin_user_edit")
     * @Entity("user", expr="repository.getById(user)")
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function updateAction(Request $request, User $user, UpdateUserUseCase $useCase)
    {
        $form = $this->createForm(UserType::class, $user);
        if ($this->handleForm($form, $request)) {
            $useCase->update($user);

            return new Response('', ResponseCodeEnum::RESPONSE_OK);
        }

        $statusCode = $this->formHasErrors($form)
            ? ResponseCodeEnum::RESPONSE_BAD_REQUEST
            : ResponseCodeEnum::RESPONSE_OK;

        return new Response(
            $this->renderView(
                'Admin/User/update.html.twig',
                [
                    'user' => $user,
                    'form' => $form->createView(),
                ]
            ),
            $statusCode
        );
    }
}
