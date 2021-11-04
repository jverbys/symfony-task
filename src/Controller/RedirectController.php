<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;
use App\Entity\User as UserEntity;

class RedirectController extends AbstractController
{
    /**
     * @Route("/redirect", name="app_redirect")
     */
    public function index(): RedirectResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        if (in_array(UserEntity::ROLE_SUPER_ADMIN, $user->getRoles())) {
            return $this->redirectToRoute('app_super_admin_home_index');
        }

        if (in_array(UserEntity::ROLE_ADMIN, $user->getRoles())) {
            return $this->redirectToRoute('app_admin_user_index');
        }

        return $this->redirectToRoute('app_home');
    }
}
