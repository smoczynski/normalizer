<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class UserController extends Controller
{
    /**
     * @Route("/users", name="get_user")
     *
     * @return JsonResponse
     */
    public function getUserListAction(): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $normalizer = $this->get('app.normalizer.factory');

        $users = $em->getRepository(User::class)->findAll();

        return new JsonResponse($normalizer->normalize($users));
    }

    /**
     * @Route("/users/{id}", name="get_user_list")
     *
     * @param User $user
     * @return JsonResponse
     */
    public function getUserAction(User $user): JsonResponse
    {
        $normalizer = $this->get('app.normalizer.factory');

        return new JsonResponse($normalizer->normalize($user));
    }
}
