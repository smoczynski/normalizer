<?php

namespace App\Controller;

use App\Entity\User;
use App\Normalizer\Base\NormalizerFactory;
use App\Repository\UserRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/performance")
 */
class PerformanceController extends Controller
{
    /**
     * @Route("/users", name="performance_user_list")
     *
     * @param NormalizerFactory $normalizer
     * @param UserRepository $userRepository
     * @param SerializerInterface $jms
     * @return JsonResponse
     */
    public function getUserListAction(NormalizerFactory $normalizer, UserRepository $userRepository, SerializerInterface $jms): Response
    {
        $users = $userRepository->findAll();

        // time without JMS
        $start = microtime(true);
        $memoryStart = memory_get_usage();
        $response = json_encode($normalizer->normalize($users));
        $memoryEnd = memory_get_usage();
        $end = microtime(true);
        $diff = round($end - $start, 4);
        $memoryDiff = round(($memoryEnd - $memoryStart)/1000000, 2);

        // time with JMS and max depth
        $startJms = microtime(true);
        $memoryJmsStart = memory_get_usage();
        $jmsResponse = $jms->serialize($users, 'json', SerializationContext::create()->enableMaxDepthChecks());
        $memoryJmsEnd = memory_get_usage();
        $endJms = microtime(true);
        $diffJms = round($endJms - $startJms, 4);
        $memoryJmsDiff = round(($memoryJmsEnd - $memoryJmsStart)/1000000, 2);

        return new Response(sprintf($this->getOutputTemplate(), count($users), $diff, $memoryDiff, $diffJms, $memoryJmsDiff));
    }

    /**
     * @Route("/users/{id}", name="performance_user")
     *
     * @param User $user
     * @param NormalizerFactory $normalizer
     * @param SerializerInterface $jms
     * @return JsonResponse
     */
    public function getUserAction(User $user, NormalizerFactory $normalizer, SerializerInterface $jms): Response
    {
        // time without JMS
        $start = microtime(true);
        $memoryStart = memory_get_usage();
        $response = json_encode($normalizer->normalize($user));
        $memoryEnd = memory_get_usage();
        $end = microtime(true);
        $diff = round($end - $start, 4);
        $memoryDiff = round(($memoryEnd - $memoryStart)/1000000, 2);

        // time with JMS and max depth
        $startJms = microtime(true);
        $memoryJmsStart = memory_get_usage();
        $jmsResponse = $jms->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());
        $memoryJmsEnd = memory_get_usage();
        $endJms = microtime(true);
        $diffJms = round($endJms - $startJms, 4);
        $memoryJmsDiff = round(($memoryJmsEnd - $memoryJmsStart)/1000000, 2);

        return new Response(sprintf($this->getOutputTemplate(), 1, $diff, $memoryDiff, $diffJms, $memoryJmsDiff));
    }

    /**
     * @return string
     */
    private function getOutputTemplate(): string
    {
        return "<style>
                td {padding: 30px; text-align: right;} 
                table {background: #98b4cc; border: 1px solid black; padding: 30px; margin: 50px; font-size: 30px;}
                .title { text-align: left;}
                </style>
                <table>
                <tr><td colspan='3' class='title'><b>Porównanie wydajności</b><BR>Ilość obiektów: %s</td></tr>
                <tr><td></td><td>Czas</td><td>Pamięć</td></tr>
                <tr><td>Bez JMS</td><td>%s s</td><td>%s MB</td></tr>
                <tr><td>Z JMS (max depth)</td><td>%s s</td><td>%s MB</td></tr>
                </table>";
    }
}
