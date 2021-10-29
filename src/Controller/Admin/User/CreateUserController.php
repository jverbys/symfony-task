<?php

namespace App\Controller\Admin\User;

use App\Entity\User;
use App\Enum\ResponseCodeEnum;
use App\Form\Handler\EntityFormTrait;
use App\Form\UserType;
use App\UseCase\User\CreateUserUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateUserController
 * @package App\Controller\Admin\User
 */
class CreateUserController extends AbstractController
{
    use EntityFormTrait;

    /**
     * @Route("/create", name="app_admin_user_create")
     *
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request, CreateUserUseCase $useCase)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        if ($this->handleForm($form, $request)) {
            $useCase->create($user);

            return new Response('', ResponseCodeEnum::RESPONSE_CREATED);
        }

        $statusCode = $this->formHasErrors($form)
            ? ResponseCodeEnum::RESPONSE_BAD_REQUEST
            : ResponseCodeEnum::RESPONSE_OK;

        return new Response(
            $this->renderView(
                'Admin/User/create.html.twig',
                [
                    'form' => $form->createView(),
                ]
            ),
            $statusCode
        );
    }
}
