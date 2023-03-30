<?php

namespace App\Controller;

use App\Entity\Account;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagementController extends AbstractController
{
    #[Route('/all_stats', name: 'app_all_stats')]
    public function doctorStats(Request $request, ManagerRegistry $managerRegistry)
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (isset($data["bearer_token"])) {
                $userAuthentification = (new \App\Service\AccountService)->checkBearerToken($data["bearer_token"], $managerRegistry);
            } else {
                $userAuthentification = (new \App\Service\AccountService)->checkUser($data["name"], $data["password"], $managerRegistry);
            }
            if ($userAuthentification->getRole() == Account::GENERAL_MANAGER and $userAuthentification->getStatus() == Account::ACTIVE_STATUS) {
                $response = new JsonResponse((new \App\Service\StatsService)->jsonStats(intval($data["id"]),$managerRegistry));
                return $response;
            }
        }catch(\Exception $exception){
            $response = new Response("Unexpected error occured. Please contact an admin and give them the following error: " . $exception);
            return $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
