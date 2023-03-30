<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\AssistantTreatment;
use App\Entity\Treatment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    function generateRandomString($length = 50) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function load(ObjectManager $manager): void
    {
        $this->loadAccounts($manager);
        $this->loadTreatments($manager);
    }
    public function loadTreatments(ObjectManager $manager): void
    {
        $data = $manager->getRepository(Account::class)->findAll();
        $assistant_id = [];
        $doctor_name = [];
        $pacients = [];
        $diagnostic = [
            "Ruptura osului mainii drepte. Recomand operatie.",
            "Ruptura osului mainii stangi. Recomand operatie.",
            "Rana adanca in zona abdomenului. Recomand dezinfectarea si supravegherea acestuia.",
            "Luxare a gleznei. Recomand fixare acesteia si recuperare.",
            "Scantirea umarului. Recomand aplicare de unguent si repaus.",
            "Iritarea ochiului. Recomand aplicarea unui tratament cu picaturi.",
            "Unghie incarnata. Recomand operatie."
        ];
        $treatment_recommended = [
            "Picaturi Oxicilo",
            "Operatie cu anestezie locala",
            "Operatie cu anestezi generala",
            "Unguent gheara ursului",
            "Repaus",
            "Aplicare de spirt, betadina"
        ];
        $assistant_treatment = [
            "Am igienizat rana",
            "Am curatat pacientul",
            "Am dat de mancare pacientului",
            "Am dat tratamentul pacientului la ora 15:00",
            "Am verificat starea de sanatate a pacientului la ora 14:45",
            "Am adus mai multe perne pacientului",
            "Am adus mai multe paturi pacientului",
            "Am schimbat camera pacientului",
            "Am cerut repararea televizorului din camera pacientului",
            "Am dat pacientului un set nou de haine"
        ];
        $status = [
            "active",
            "finished",
            "in progress"
        ];
        foreach($data as $info){
            if($info->getRole() == "ASSISTANT") {
                $assistant_id[] = $info->getId();
            }else if($info->getRole() == "DOCTOR") {
                $doctor_name[] = $info->getName() . " " . $info->getSurname();
            }else if($info->getRole() == "PACIENT") {
                $pacients[] = [$info->getId(),$info->getName() . " " . $info->getSurname()];
            }
        }
        $pacients_treatments = [];
        $currentDateTime = new \DateTimeImmutable();
        foreach($pacients as $pacient){
            $assistant = $assistant_id[array_rand($assistant_id)];
            $treatment = new Treatment();
            $treatment->setStatus($status[array_rand($status)])
                ->setAge(rand(24,45))
                ->setCreatedAt($currentDateTime)
                ->setDiagnostic($diagnostic[array_rand($diagnostic)])
                ->setMedicalConditions("None")
                ->setPacientName($pacient[1])
                ->setRecommendedBy($doctor_name[array_rand($doctor_name)])
                ->setUpdatedAt($currentDateTime)
                ->setPacientId($pacient[0])
                ->setTreatment($treatment_recommended[array_rand($treatment_recommended)])
                ->setAssistantId($assistant);
            $manager->persist($treatment);
            $manager->flush();
            $pacients_treatments[] = [$pacient[0],$assistant];
        }

        foreach($pacients_treatments as $info){
            $treatment = new AssistantTreatment();
            $treatment->setPacientId($info[0]);
            $treatment->setAssistantId($info[1]);
            $treatment->setTreatmentApplied($assistant_treatment[array_rand($assistant_treatment)]);
            $treatment->setCreatedAt($currentDateTime);
            $manager->persist($treatment);
            $manager->flush();

            $treatment = new AssistantTreatment();
            $treatment->setPacientId($info[0]);
            $treatment->setAssistantId($info[1]);
            $treatment->setTreatmentApplied($assistant_treatment[array_rand($assistant_treatment)]);
            $treatment->setCreatedAt($currentDateTime);
            $manager->persist($treatment);
            $manager->flush();

            $treatment = new AssistantTreatment();
            $treatment->setPacientId($info[0]);
            $treatment->setAssistantId($info[1]);
            $treatment->setTreatmentApplied($assistant_treatment[array_rand($assistant_treatment)]);
            $treatment->setCreatedAt($currentDateTime);
            $manager->persist($treatment);
            $manager->flush();
        }
    }
    public function loadAccounts(ObjectManager $manager): void
    {
        $account_data = [
            ["Tanasa","Florin Petrisor","GENERAL_MANAGER"],
            ["Dilirici","Mihai","DOCTOR"],
            ["Ghetoiu","Laurentiu","DOCTOR"],
            ["Florea","Madalin","DOCTOR"],
            ["Besliu","Radu","ASSISTANT"],
            ["Militaru","Mihai","ASSISTANT"],
            ["Cazacu","Cristian","ASSISTANT"],
            ["Stanciu","Carol","ASSISTANT"],
            ["Qulescu","Wulescu","PACIENT"],
            ["Eulescu","Rulescu","PACIENT"],
            ["Tulescu","Yulescu","PACIENT"],
            ["Uulescu","Iulescu","PACIENT"],
            ["Oulescu","Pulescu","PACIENT"],
            ["Aulescu","Sulescu","PACIENT"]
        ];
        foreach($account_data as $account){
            $new_account = new Account();
            $new_account->setName($account[0])
                ->setSurname($account[1])
                ->setBearerToken($this->generateRandomString())
                ->setPassword("parola123")
                ->setRole($account[2])
                ->setStatus("active");
            $manager->persist($new_account);
            $manager->flush();
        }
    }
}