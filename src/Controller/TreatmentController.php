<?php

namespace App\Controller;

use App\Entity\Account;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TreatmentController extends AbstractController
{
    private const ALLOWED_ROLES = [
        Account::GENERAL_MANAGER,
        Account::DOCTOR
    ];
    #[Route('/treatment', name: 'app_treatment', methods:['POST'])]
    public function treatmentManagement(Request $request, ManagerRegistry $managerRegistry)
    {
        try {
            $data = json_decode($request->getContent(), true);
            if(isset($data["bearer_token"])){
                $userAuthentification = (new \App\Service\AccountService)->checkBearerToken($data["bearer_token"], $managerRegistry);
            }else {
                $userAuthentification = (new \App\Service\AccountService)->checkUser($data["name"], $data["password"], $managerRegistry);
            }
            if ($userAuthentification and $userAuthentification->getStatus() == Account::INACTIVE_STATUS) {
                if(in_array($userAuthentification->getRole(),self::ALLOWED_ROLES)){
                    $data["info"]["medic"] = $userAuthentification->getName() . " " . $userAuthentification->getSurname();
                    if($data["action"]=="create") {
                        if($userAuthentification->getRole() == Account::DOCTOR) {
                            $status = (new \App\Service\TreatmentService)->createTreatment($data["info"], $managerRegistry);
                        }else{
                            $response = new Response("You don't have the permissions to create treatments.");
                            return $response->setStatusCode(403);
                        }
                    }
                    if($data["action"]=="read") {
                        $response = new JsonResponse((new \App\Service\TreatmentService())->readTreatment($data["info"], $managerRegistry));
                        return $response;
                    }
                    if($data["action"]=="update") {
                        if(isset($data["info"]['treatment']) and $userAuthentification->getRole() != Account::DOCTOR){
                            $response = new Response("You are not allowed to modify a doctor's treatment.");
                            return $response->setStatusCode(403);
                        }
                        $status = (new \App\Service\TreatmentService)->updateTreatment($data["info"], $managerRegistry);
                    }
                    if($data["action"]=="delete") {
                        $status = (new \App\Service\TreatmentService)->deleteTreatment($data["info"], $managerRegistry);
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
    #[Route('/assistant_treatment', name: 'app_assistant_treatment', methods:['POST'])]
    public function AssistantTreatment(Request $request, ManagerRegistry $managerRegistry){
        try {
            $data = json_decode($request->getContent(), true);
            if(isset($data["bearer_token"])){
                $userAuthentification = (new \App\Service\AccountService)->checkBearerToken($data["bearer_token"], $managerRegistry);
            }else {
                $userAuthentification = (new \App\Service\AccountService)->checkUser($data["name"], $data["password"], $managerRegistry);
            }
            if ($userAuthentification and $userAuthentification->getStatus() == Account::INACTIVE_STATUS) {
                if($userAuthentification->getRole() == Account::ASSISTANT){
                    $data["info"]["assistant_id"] = $userAuthentification->getId();
                    if($data["action"]=="create") {
                        $status = (new \App\Service\TreatmentService())->assistantCreateTreatment($data["info"], $managerRegistry);
                    }
                    if($data["action"]=="read") {
                        $response = new JsonResponse((new \App\Service\TreatmentService())->assistantReadTreatment($data["info"], $managerRegistry));
                        return $response;
                    }
                    if($data["action"]=="update") {
                        $status = (new \App\Service\TreatmentService())->assistantUpdateTreatment($data["info"], $managerRegistry);
                    }
                    if($data["action"]=="delete") {
                        $status = (new \App\Service\TreatmentService())->assistantDeleteTreatment($data["info"], $managerRegistry);
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
    #[Route('/all_treatments', name: 'app_all_treatments', methods:['GET'])]
    public function readAllTreatments(Request $request, ManagerRegistry $managerRegistry){
        try {
            $data = json_decode($request->getContent(), true);
            if (isset($data["bearer_token"])) {
                $userAuthentification = (new \App\Service\AccountService)->checkBearerToken($data["bearer_token"], $managerRegistry);
            } else {
                $userAuthentification = (new \App\Service\AccountService)->checkUser($data["name"], $data["password"], $managerRegistry);
            }
            if ($userAuthentification and $userAuthentification->getStatus == Account::INACTIVE_STATUS) {
                $doctor_treatment = (new \App\Service\TreatmentService())->readTreatment(["pacient_id"=>$data["pacient_id"]], $managerRegistry);
                $assistant_treatment = (new \App\Service\TreatmentService())->assistantReadTreatment(["pacient_id"=>$data["pacient_id"]], $managerRegistry);
                $doctor_treatment["assistants_treatments"] = $assistant_treatment["assistants_treatments"];
                $response = new JsonResponse($doctor_treatment);
                return $response;
            }
        }catch(\Exception $exception){
            $response = new Response("Unexpected error occured. Please contact an admin and give them the following error: " . $exception);
            return $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }
}