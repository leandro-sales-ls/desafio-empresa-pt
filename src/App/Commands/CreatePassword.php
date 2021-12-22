<?php
namespace Console\App\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
 
class CreatePassword extends Command
{
    protected function configure()
    {
        $this->setName('create-pwd')
            ->setDescription('Prints create-pwd!')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addArgument('id', InputArgument::REQUIRED, 'Pass the first name.')
            ->addArgument('password', InputArgument::REQUIRED, 'Pass the last name.')
            ->addArgument('confirmPassword', InputArgument::REQUIRED, 'Pass the email.');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $return = '';
        $erros = $this->validation($input);

        if ($erros) {
            throw new \Exception(implode('; ',$erros));
        } else {
            $return = password_hash($input->getArgument('password'), PASSWORD_BCRYPT, ['cost' => 10]);
        }

        $output->writeln($return);
        
        return Command::SUCCESS;
    }

    public function validation(InputInterface $input)
    {
        $erros = [];
        $ids = [1,3,5,9,35,10];

        if (!in_array($input->getArgument('id'), $ids)) {
            array_push($erros, 'Usuario não encontrado');
        }

        if ($input->getArgument('password') != $input->getArgument('confirmPassword')) {
            array_push($erros, 'Senha não confere');
        }

        if (!$this->validationPassword($input->getArgument('password'))) {
            array_push($erros, 'Senha não atende os requisitos');
        }

        return $erros;
    }

    public function validationPassword($pwd)
    {
        $regex = "/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/";
        return (bool)preg_match($regex, $pwd);
    }

}