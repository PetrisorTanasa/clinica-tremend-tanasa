<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository;
use App\Service\AccountService;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends AbstractController
{
    private const ALLOWED_ROLES = [
        Account::GENERAL_MANAGER
    ];
    private const RESTRICTED_ROLES = [
        Account::DOCTOR
    ];
    private const FORBIDDEN_ROLES = [
        Account::ASSISTANT,
        Account::PACIENT
    ];
    #[Route('/login', name: 'app_login', methods:['POST'])]
    public function login(Request $request, ManagerRegistry $managerRegistry)
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (count($data) > 2) {
                $response = new Response("Not a valid request, the json should only have 2 parameters, name and password.");
                return $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            }
            $userAuthentification = (new \App\Service\AccountService)->checkUser($data["name"], $data["password"], $managerRegistry);
            if ($userAuthentification) {
                if($userAuthentification->getStatus() == Account::INACTIVE_STATUS){
                    $response = new Response("Your account has been deactivated. Contact the system admin if you there has been a mistake");
                    return $response->setStatusCode(Response::HTTP_FORBIDDEN);
                }
                return $this->json([
                    'message' => 'Welcome to clinica Tremend!',
                    'bearer_token' => $userAuthentification->getBearerToken(),
                ]);
            } else {
                $response = new Response("Login failed");
                return $response->setStatusCode(403);
            }
        }catch(\Exception $exception){
            $response = new Response("Unexpected error occured. Please contact an admin and give them the following error: " . $exception);
            return $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
    #[Route('/manageAccounts', name: 'app_manage_accounts', methods:['POST'])]
    public function create_account(Request $request, ManagerRegistry $managerRegistry)
    {
        try {
            $data = json_decode($request->getContent(), true);
            if(isset($data["bearer_token"])){
                $userAuthentification = (new \App\Service\AccountService)->checkBearerToken($data["bearer_token"], $managerRegistry);
            }else {
                $userAuthentification = (new \App\Service\AccountService)->checkUser($data["name"], $data["password"], $managerRegistry);
            }
            if ($userAuthentification and $userAuthentification->getStatus() != Account::INACTIVE_STATUS) {
                if(in_array($userAuthentification->getRole(),self::ALLOWED_ROLES) or ($data["action"] != "delete" and in_array($userAuthentification->getRole(),self::RESTRICTED_ROLES) and in_array($data["info"]["role"],self::FORBIDDEN_ROLES))){
                    if($data["action"]=="create") {
                        $status = (new \App\Service\AccountService)->createUser($data["info"], $managerRegistry);
                    }
                    if($data["action"]=="update") {
                        $status = (new \App\Service\AccountService)->updateUser($data["info"], $managerRegistry);
                    }
                    if($data["action"]=="delete") {
                        $status = (new \App\Service\AccountService)->deleteUser($data["info"], $managerRegistry);
                    }
                    if($status == false){
                        $response = new Response("Unexpected error occured. We are sorry for the inconvenience :/");
                        return $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
                    }
                    return $this->json([
                        'message' => 'Action completed!'
                    ]);
                }else{
                    $response = new Response("You don't have the permissions for this action");
                    return $response->setStatusCode(403);
                }
            } else {
                $response = new Response("Login failed");
                return $response->setStatusCode(403);
            }
        }catch(\Exception $exception){
            $response = new Response("Unexpected error occured. Please contact an admin and give them the following error: " . $exception);
            return $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}
