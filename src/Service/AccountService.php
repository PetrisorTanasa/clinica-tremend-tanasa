<?php

namespace App\Service;


use App\Entity\Account;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectRepository;

class AccountService
{
    private const POSSIBLE_ROLES = [
        "GENERAL_MANAGER",
        "DOCTOR",
        "ASSISTANT",
        "PACIENT"
    ];
    function generateRandomString($length = 50) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function checkUser(string $name, string $password, ManagerRegistry $managerRegistry){
        $account = $managerRegistry->getManager()->getRepository(Account::class)->findOneBy(["name"=>$name,"password"=>$password]);
        if(isset($account)){
            return $account;
        }else{
            return false;
        }
    }
    public function checkBearerToken(string $bearer_token, ManagerRegistry $managerRegistry){
        $account = $managerRegistry->getManager()->getRepository(Account::class)->findOneBy(["bearer_token"=>$bearer_token]);
        if(isset($account)){
            return $account;
        }else{
            return false;
        }
    }
    public function createUser(array $account_data, ManagerRegistry $managerRegistry){
        if(in_array($account_data["role"],Account::POSSIBLE_ROLES)) {
            $new_account = new Account();
            $new_account->setName($account_data["name"])
                ->setSurname($account_data["surname"])
                ->setBearerToken($this->generateRandomString())
                ->setPassword($account_data["password"])
                ->setRole($account_data["role"])
                ->setStatus($account_data["status"]);
            $managerRegistry->getManager()->persist($new_account);
            $managerRegistry->getManager()->flush();
            return true;
        }else{
            return false;
        }
    }
    public function updateUser(array $account_data, ManagerRegistry $managerRegistry){
        if(in_array($account_data["role"],Account::POSSIBLE_ROLES)) {
            $update_data = $managerRegistry->getRepository(Account::class)->find($account_data["id"]);
            $update_data->setName($account_data["name"])
                ->setSurname($account_data["surname"])
                ->setBearerToken($this->generateRandomString())
                ->setPassword($account_data["password"])
                ->setRole($account_data["role"])
                ->setStatus($account_data["status"]);
            $managerRegistry->getManager()->persist($update_data);
            $managerRegistry->getManager()->flush();
            return true;
        }else{
            return false;
        }
    }
    public function deleteUser(array $account_data, ManagerRegistry $managerRegistry){
        $deleted_data = $managerRegistry->getRepository(Account::class)->find($account_data["id"]);
        $managerRegistry->getManager()->remove($deleted_data);
        $managerRegistry->getManager()->flush();
    }
}
