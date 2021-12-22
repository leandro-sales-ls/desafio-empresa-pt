<?php
namespace Console\App\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
 
class UserCreateCommand extends Command
{
    protected function configure()
    {
        $this->setName('create')
            ->setDescription('Prints create!')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addArgument('firstName', InputArgument::REQUIRED, 'Pass the first name.')
            ->addArgument('lastName', InputArgument::REQUIRED, 'Pass the last name.')
            ->addArgument('email', InputArgument::REQUIRED, 'Pass the email.')
            ->addArgument('age', InputArgument::OPTIONAL, 'Pass the age.');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $return = '';
        $erros = $this->validation($input);

        if ($erros) {
            throw new \Exception(implode('; ',$erros));
        } else {
            $return = [
                "firstName" => $input->getArgument('firstName'),
                "lastName"  => $input->getArgument('lastName'),
                "email"     => $input->getArgument('email'),
                "age"       => $input->getArgument('age'),
            ];
            $return = json_encode($return);
        }

        $output->writeln($return);
        
        return Command::SUCCESS;
    }

    public function validation(InputInterface $input)
    {
        $erros = [];

        if (strlen($input->getArgument('firstName')) < 2 || 
            strlen($input->getArgument('firstName')) > 35
        ) {
            array_push($erros, 'Erro primeiro nome');
        } 

        if (strlen($input->getArgument('lastName')) < 2 ||
            strlen($input->getArgument('lastName')) > 35
        ) {
            array_push($erros, 'Erro segundo nome');
        } 
        
        if (!$this->validationEmail($input->getArgument('email'))) {
            array_push($erros, 'E-mail invalido');
        }
        
        if (empty($input->getArgument('age')) &&
           ($input->getArgument('age') > 150 ||
            $input->getArgument('age') > 0)
        ) {
            array_push($erros, 'A idade tem que ser menor que 150 anos e maior que 0');
        } 

        return $erros;
    }

    public function validationEmail($email)
    {
        $regex = "/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/";
        return (bool)preg_match($regex, $email);
    }

}