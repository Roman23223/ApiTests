<?php

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Entity\UserUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class RegistrationController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator,
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {}


    public function __invoke(UserUser $data): UserUser
    {
        //ПРОВЕРКА ДАННЫХ
        $this->validator->validate($data);

        // СОЗДАНИЕ ПОЛЬЗОВАТЕЛЯ
        $data->setEmail($data->getEmail());
        $data->setRoles(roles: ["ROLE_USER"]);
        $data->setPassword($this->userPasswordHasher->hashPassword($data, $data->getPassword()));

        // ОБНОВЛЕНИЕ
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }


}
