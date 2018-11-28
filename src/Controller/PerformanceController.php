<?php

namespace App\Controller;

use App\Entity\User;
use JMS\Serializer\SerializationContext;
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
     * @return JsonResponse
     */
    public function getUserListAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $normalizer = $this->get('app.normalizer.factory');
        $jms = $this->get('jms_serializer');
        $users = $em->getRepository(User::class)->findAll();

        // time without JMS
        $start = microtime(true);
        $response = new JsonResponse($normalizer->normalize($users));
        $end = microtime(true);
        $diff = round($end - $start, 5);

        // time with JMS and max depth
        $startJms = microtime(true);
        $jmsResponse = $jms->serialize($users, 'json', SerializationContext::create()->enableMaxDepthChecks());
        $endJms = microtime(true);
        $diffJms = round($endJms - $startJms, 5);

        return new Response(sprintf($this->getOutputTemplate(), count($users), $diff, $diffJms));
    }

    /**
     * @Route("/users/{id}", name="performance_user")
     *
     * @param User $user
     * @return JsonResponse
     */
    public function getUserAction(User $user): Response
    {
        $normalizer = $this->get('app.normalizer.factory');
        $jms = $this->get('jms_serializer');

        // time without JMS
        $start = microtime(true);
        $response = json_encode($normalizer->normalize($user));
        $end = microtime(true);
        $diff = round($end - $start, 5);

        // time with JMS and max depth
        $startJms = microtime(true);
        $jmsResponse = $jms->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());
        $endJms = microtime(true);
        $diffJms = round($endJms - $startJms, 5);

        return new Response(sprintf($this->getOutputTemplate(), 1, $diff, $diffJms));
    }

    /**
     * @return string
     */
    private function getOutputTemplate(): string
    {
        return "<style>td {padding: 30px;} table {background: #DAFFE1; border: 1px solid black; 
                padding: 30px; margin: 50px; font-size: 30px;}</style>
                <table><tr><td colspan='2'>Porównanie wydajności<BR>Ilość obiektów: %s</td></tr><tr><td>Bez JMS</td><td>%s</td></tr>
                <tr><td>Z JMS (max depth)</td><td>%s</td></tr></table>";
    }
}
