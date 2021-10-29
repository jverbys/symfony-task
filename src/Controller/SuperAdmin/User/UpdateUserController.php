<?php

namespace App\Controller\SuperAdmin\User;

use App\Entity\User;
use App\Form\UserType;
use App\Enum\ResponseCodeEnum;
use App\Form\Handler\EntityFormTrait;
use App\UseCase\User\UpdateUserUseCase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UpdateUserController
 * @package App\Controller\SuperAdmin\User
 */
class UpdateUserController extends AbstractController
{
    use EntityFormTrait;

    /**
     * @Route("/{user}/edit", name="app_super_admin_user_edit")
     * @ParamConverter(
     *     "user",
     *     class="App:User"
     * )
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function updateAction(Request $request, $user, UpdateUserUseCase $useCase)
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
                'SuperAdmin/User/update.html.twig',
                [
                    'user' => $user,
                    'form' => $form->createView(),
                ]
            ),
            $statusCode
        );
    }
}
