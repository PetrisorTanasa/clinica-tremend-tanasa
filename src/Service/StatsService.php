<?php

namespace App\Service;

use App\Entity\Account;
use App\Entity\AssistantTreatment;
use App\Entity\Treatment;
use Doctrine\Persistence\ManagerRegistry;

class StatsService
{
    public function jsonStats(int $medic_id, ManagerRegistry $managerRegistry){
        $account = $managerRegistry->getRepository(Account::class)->find($medic_id);
        if($account->getRole() == Account::DOCTOR){
            $response["doctor_name"] = $account->getName();
            $response["doctor_surname"] = $account->getSurname();
            $response["role"] = $account->getRole();
            $response["status"] = $account->getStatus();
            $response["pacients"] = $this->medicStats($account->getName() . " " . $account->getSurname(),$managerRegistry);
            return $response;
        }else if($account->getRole() == Account::ASSISTANT){
            $response["assistent_name"] = $account->getName();
            $response["assistent_surname"] = $account->getSurname();
            $response["role"] = $account->getRole();
            $response["status"] = $account->getStatus();
            $response["pacients"] = $this->assistentStats($account->getId(),$managerRegistry);
            return $response;
        }
        return false;
    }
    public function medicStats(string $medic_name, ManagerRegistry $managerRegistry){
        $pacient_data = $managerRegistry->getRepository(Treatment::class)->findBy(["recommended_by"=>$medic_name],["created_at"=>"DESC"]);
        $response = [];
        foreach($pacient_data as $pacient){
            $aux = [];
            if(!isset($response[$pacient->getId()])){
                $response[$pacient->getId()]["name"] = $pacient->getPacientName();
            }
            $aux["medical_conditions"] = $pacient->getMedicalConditions();
            $aux["age"] = $pacient->getAge();
            $aux["diagnostic"] = $pacient->getDiagnostic();
            $aux["treatment"] = $pacient->getTreatment();
            $aux["created_at"] = $pacient->getCreatedAt();
            $aux["updated_at"] = $pacient->getUpdatedAt();
            $response[$pacient->getId()]["treatments"][] = $aux;
        }
        return $response;
    }
    public function assistentStats(int $assistant_id, ManagerRegistry $managerRegistry){
        $pacient_data = $managerRegistry->getRepository(AssistantTreatment::class)->findBy(["assistant_id"=>$assistant_id],["created_at"=>"DESC"]);
        $response = [];
        foreach($pacient_data as $pacient){
            $aux = [];
            if(!isset($response[$pacient->getPacientId()])){
                $pacient_name = $managerRegistry->getRepository(Account::class)->findBy(["id"=>$pacient->getPacientId()]);
                $response[$pacient->getPacientId()]["name"] = $pacient_name[0]->getName() . " " . $pacient_name[0]->getSurname();
            }
            $aux["treatment"] = $pacient->getTreatmentApplied();
            $aux["created_at"] = $pacient->getCreatedAt();
            $aux["updated_at"] = $pacient->getUpdatedAt();
            $response[$pacient->getPacientId()]["treatments"][] = $aux;
        }
        return $response;
    }
}