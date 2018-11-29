<?php

namespace App\Controller;

use App\Entity\User;
use App\Normalizer\Base\NormalizerFactory;
use App\Repository\UserRepository;
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
     * @param NormalizerFactory $normalizer
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function getUserListAction(NormalizerFactory $normalizer, UserRepository $userRepository): JsonResponse
    {
        return new JsonResponse($normalizer->normalize($userRepository->findAll()));
    }

    /**
     * @Route("/users/{id}", name="get_user_list")
     *
     * @param User $user
     * @param NormalizerFactory $normalizer
     * @return JsonResponse
     */
    public function getUserAction(User $user, NormalizerFactory $normalizer): JsonResponse
    {
        return new JsonResponse($normalizer->normalize($user));
    }
}
