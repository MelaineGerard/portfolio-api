<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Permet de créer un utilisateur',
)]
class CreateUserCommand extends Command
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask('Email de l\'utilisateur');
        $password = $io->askHidden('Mot de passe de l\'utilisateur');

        $user = new User;
        $user->setEmail($email);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $password
        ));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('Utilisateur créé avec succès !');

        return Command::SUCCESS;
    }
}
