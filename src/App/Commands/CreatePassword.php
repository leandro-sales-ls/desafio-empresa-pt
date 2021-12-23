<?php
namespace Console\App\Commands;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Services\AccountService;
use App\Repositories\Account\AccountRepository;
 
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
            $data = [
                "password" => password_hash($input->getArgument('password'), PASSWORD_BCRYPT, ['cost' => 10]),
            ];
             if ($this->update($input->getArgument('id'), $data)) $return = 'Senha cadastrada.';
        }

        $output->writeln($return);
        
        return $return;
    }

    public function validation(InputInterface $input)
    {
        $erros = [];

        if (!(new AccountRepository)->getByID($input->getArgument('id'))) {
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

    public function update($id, array $param)
    {
        return (new AccountRepository)->update($id, $param);
    }

}