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
        if(isset($treatment["pacient_id"])){
        $treatment->setStatus($treatment_data["status"])
            ->setAge($treatment_data["status"])
            ->setCreatedAt($currentDateTime)
            ->setDiagnostic($treatment_data["diagnostic"])
            ->setMedicalConditions($treatment_data["medical_conditions"])
            ->setPacientName($treatment_data["pacient_name"])
            ->setRecommendedBy($treatment_data["medic"])
            ->setUpdatedAt($currentDateTime)
            ->setPacientId($treatment["pacient_id"])
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
        $pacient_data = $managerRegistry->getRepository(Treatment::class)->findBy(["pacient_id"=>$treatment_data["pacient_id"]]);
        $returned_data["pacient_name"] = $pacient_data[0]->getPacientName();
        foreach($pacient_data as $info){
            $returned_data["info"][]["treatment_id"] = $info->getId();
            $returned_data["info"][]["pacient_age"] = $info->getAge();
            $returned_data["info"][]["medical_conditions"] = $info->getMedicalConditions();
            $returned_data["info"][]["diagnostic"] = $info->getDiagnostic();
            $returned_data["info"][]["status"] = $info->getStatus();
            $returned_data["info"][]["medic"] = $info->getRecommendedBy();
            $returned_data["info"][]["assistant_id"] = $info->getAssistant_id();
            $returned_data["info"][]["created_at"] = $info->getCreatedAt();
            $returned_data["info"][]["updated_at"] = $info->getUpdatedAt();
        }
        return $returned_data;
    }
    public function updateTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $treatment = $managerRegistry->getRepository(Treatment::class)->findOneBy(["id"=>$treatment_data["info"]["id"]]);
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
        $treatment = $managerRegistry->getRepository(Treatment::class)->findOneBy(["id"=>$treatment_data["info"]["id"]]);
        $managerRegistry->getManager()->remove($treatment);
        $managerRegistry->getManager()->flush();
    }

    public function assistantCreateTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $treatment = new AssistantTreatment();
        $treatment->setPacientId($treatment_data["pacient_id"]);
        $treatment->setAssistantId($treatment_data["assistant_id"]);
        $treatment->setTreatmentApplied($treatment_data["treatment"]);
        $managerRegistry->getManager()->persist($treatment);
        $managerRegistry->getManager()->flush();
    }
    public function assistantReadTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $returned_data = [];
        $treatment_info = $managerRegistry->getRepository(AssistantTreatment::class)->findBy(["pacient_id"=>$treatment_data["info"]["pacient_id"]]);
        foreach($treatment_info as $info){
            $returned_data[]["assistant_id"] = $info->getAssistantId();
            $returned_data[]["treatment_applied"] = $info->getTreatmentApplied();
        }
        return $returned_data;
    }
    public function assistantUpdateTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $treatment = $managerRegistry->getRepository(AssistantTreatment::class)->findOneBy(["id"=>$treatment_data["info"]["id"]]);
        $treatment->setPacientId($treatment_data["pacient_id"]);
        $treatment->setAssistantId($treatment_data["assistant_id"]);
        $treatment->setTreatmentApplied($treatment_data["treatment"]);
        $managerRegistry->getManager()->persist($treatment);
        $managerRegistry->getManager()->flush();
    }
    public function assistantDeleteTreatment(array $treatment_data, ManagerRegistry $managerRegistry){
        $treatment = $managerRegistry->getRepository(AssistantTreatment::class)->findOneBy(["id"=>$treatment_data["info"]["id"]]);
        $managerRegistry->getManager()->remove($treatment);
        $managerRegistry->getManager()->flush();
    }
}