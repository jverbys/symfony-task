<?php

namespace App\Controller\Admin\User;

use App\UseCase\User\ListUsersUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexUserController
 * @package App\Controller\Admin\User
 */
class IndexUserController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_user_index")
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request, ListUsersUseCase $useCase)
    {
        $page = $request->query->getInt('page', 1);
        return $this->render(
            'Admin/User/index.html.twig',
            [
                'users' => $useCase->getPaginatedResults($page)
            ]
        );
    }
}
