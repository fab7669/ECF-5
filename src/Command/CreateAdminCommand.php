<?php
// filepath: c:\wamp64\www\ecf5\gestion-creche\src\Command\CreateAdminCommand.php


namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:create-admin')]
class CreateAdminCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Créer un nouvel utilisateur
        $user = new User();
        $user->setEmail('admin@creche.fr');
        
        // Hasher le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'Admin123!'
        );
        
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN']);

        // Sauvegarder dans la base de données
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('Utilisateur admin créé avec succès !');

        return Command::SUCCESS;
    }
}