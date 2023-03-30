<?php

namespace App\Service;


use App\Entity\Account;
use App\Entity\AssistantTreatment;
use App\Entity\Treatment;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

class TreatmentService
{
    public function createTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $treatment = new Treatment();
        $currentDateTime = new \DateTimeImmutable();
//        $aux_data = explode(" ",$treatment_data["pacient_name"],1);
//        $pacient_id = $managerRegistry->getRepository(Account::class)->findOneBy(["name"=>$aux_data[0],"surname"=>$aux_data[1]]);
        if(isset($treatment_data["pacient_id"])){
        $treatment->setStatus($treatment_data["status"])
            ->setAge($treatment_data["age"])
            ->setCreatedAt($currentDateTime)
            ->setDiagnostic($treatment_data["diagnostic"])
            ->setMedicalConditions($treatment_data["medical_conditions"])
            ->setPacientName($treatment_data["pacient_name"])
            ->setRecommendedBy($treatment_data["medic"])
            ->setUpdatedAt($currentDateTime)
            ->setPacientId($treatment_data["pacient_id"])
            ->setTreatment($treatment_data["treatment"])
            ->setAssistantId($treatment_data["assistant_id"]);
        $managerRegistry->getManager()->persist($treatment);
        $managerRegistry->getManager()->flush();
        return true;
        }else{
            return false;
        }
    }
    public function readTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $pacient_data = $managerRegistry->getRepository(Treatment::class)->findBy(["pacient_id" => $treatment_data["pacient_id"]], ['created_at' => 'DESC']);
        $returned_data["pacient_name"] = $pacient_data[0]->getPacientName();
        foreach($pacient_data as $info){
            $aux = [];
            $aux["treatment_id"] = $info->getId();
            $aux["pacient_age"] = $info->getAge();
            $aux["medical_conditions"] = $info->getMedicalConditions();
            $aux["diagnostic"] = $info->getDiagnostic();
            $aux["status"] = $info->getStatus();
            $aux["medic"] = $info->getRecommendedBy();
            $aux["assistant_id"] = $info->getAssistantId();
            $aux["created_at"] = $info->getCreatedAt();
            $aux["updated_at"] = $info->getUpdatedAt();
            $returned_data["treatments"][] = $aux;
        }
        return $returned_data;
    }
    public function updateTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $treatment = $managerRegistry->getRepository(Treatment::class)->findOneBy(["id"=>$treatment_data["id"]]);
        if(isset($treatment)){
            $currentDateTime = new \DateTimeImmutable();
//            $aux_data = explode(" ",$treatment_data["pacient_name"],1);
//            $pacient_id = $managerRegistry->getRepository(Account::class)->findOneBy(["name"=>$aux_data[0],"surname"=>$aux_data[1]]);
            $treatment->setStatus($treatment_data["status"])
                ->setAge($treatment_data["status"])
                ->setDiagnostic($treatment_data["diagnostic"])
                ->setMedicalConditions($treatment_data["medical_conditions"])
                ->setPacientName($treatment_data["pacient_name"])
                ->setUpdatedAt($currentDateTime)
                ->setPacientId($treatment_data["pacient_id"])
                ->setTreatment($treatment_data["treatment"])
                ->setAssistantId($treatment_data["assistant_id"]);
            if(isset($treatment_data["diagnostic"])){
                $treatment->setRecommendedBy($treatment_data["medic"]);
            }
            $managerRegistry->getManager()->persist($treatment);
            $managerRegistry->getManager()->flush();
            return true;
        }else{
            return false;
        }
    }
    public function deleteTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $treatment = $managerRegistry->getRepository(Treatment::class)->findOneBy(["id"=>$treatment_data["id"]]);
        $managerRegistry->getManager()->remove($treatment);
        $managerRegistry->getManager()->flush();
        return true;
    }

    public function assistantCreateTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $currentTime = new \DateTimeImmutable();
        $treatment = new AssistantTreatment();
        $treatment->setPacientId($treatment_data["pacient_id"]);
        $treatment->setAssistantId($treatment_data["assistant_id"]);
        $treatment->setTreatmentApplied($treatment_data["treatment"]);
        $treatment->setCreatedAt($currentTime);
        $managerRegistry->getManager()->persist($treatment);
        $managerRegistry->getManager()->flush();
        return true;
    }
    public function assistantReadTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $returned_data = [];
        $treatment_info = $managerRegistry->getRepository(AssistantTreatment::class)->findBy(["pacient_id"=>$treatment_data["pacient_id"]], ['created_at' => 'DESC']);
        foreach($treatment_info as $info){
            $aux = [];
            $aux["assistant_id"] = $info->getAssistantId();
            $aux["treatment_applied"] = $info->getTreatmentApplied();
            $aux["created_at"] = $info->getCreatedAt();
            $aux["updated_at"] = $info->getUpdatedAt();
            $returned_data["assistants_treatments"][] = $aux;
        }
        return $returned_data;
    }
    public function assistantUpdateTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $currentTime = new \DateTimeImmutable();
        $treatment = $managerRegistry->getRepository(AssistantTreatment::class)->findOneBy(["id"=>$treatment_data["id"]]);
        $treatment->setPacientId($treatment_data["pacient_id"]);
        $treatment->setAssistantId($treatment_data["assistant_id"]);
        $treatment->setTreatmentApplied($treatment_data["treatment"]);
        $treatment->setUpdatedAt($currentTime);
        $managerRegistry->getManager()->persist($treatment);
        $managerRegistry->getManager()->flush();
        return true;
    }
    public function assistantDeleteTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $treatment = $managerRegistry->getRepository(AssistantTreatment::class)->findOneBy(["id"=>$treatment_data["id"]]);
        $managerRegistry->getManager()->remove($treatment);
        $managerRegistry->getManager()->flush();
        return true;
    }
}