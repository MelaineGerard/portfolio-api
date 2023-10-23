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
    name: 'app:user:make',
    description: 'Permet de créer un utilisateur (Admin, User)',
)]
class UserMakeCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $userPasswordHasher

    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask("Email de l'utilisateur : ");
        $password = $io->askHidden("Mot de passe de l'utilisateur : ");
        $isAdministrator = $io->confirm("Est-ce un administrateur ? ");

        $io->info("Création de l'utilisateur en cours...");

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));

        if ($isAdministrator) {
            $user->setRoles(['ROLE_ADMIN']);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();


        $io->success('Utilisateur créé avec succès !');

        return Command::SUCCESS;
    }
}
