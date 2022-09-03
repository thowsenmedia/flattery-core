<?php

namespace ThowsenMedia\Flattery\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{

    protected static $defaultName = 'user:create';

    protected function configure(): void
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'Username');
        $this->addArgument('email', InputArgument::REQUIRED, 'Email');
        $this->addArgument('password', InputArgument::OPTIONAL, 'Password');
        
        $this->addOption('admin', 'a');

        $this->setHelp("Create a new user.");

        $this->addUsage('john john@gmail.com -admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $password_was_generated = false;

        if ($password == NULL) {
            $password = str_random(16);
            $password_was_generated = true;
        }

        if (data()->has('users', $username)) {
            $output->writeln("A user with that username already exists.");
            return Command::FAILURE;
        }

        foreach(data()->get('users') as $fields) {
            if ($fields['email'] == $email) {
                $output->writeln("A user with that email already exists.");
                return Command::FAILURE;
            }
        }

        data()->set('users', $username, [
            'admin' => $input->getOption('admin'),
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $output->writeln($input->getOption('admin') ? 'Admin user created.' : 'User created.');
        if ($password_was_generated) {
            $output->writeln("Your password is $password");
        }
        return Command::SUCCESS;
    }

}