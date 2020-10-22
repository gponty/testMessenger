<?php

namespace App\Command;

use App\Entity\Traitement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class ExecuteTraitementCommand extends Command
{
    protected static $defaultName = 'execute:traitement';
    private $bus;

    /**
     * ExecuteTraitementCommand constructor.
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus)
    {

        $this->bus = $bus;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Lancement de traitement')
            ->addArgument('nbTraitement', InputArgument::OPTIONAL, 'Nombre de traitement à effectuer.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('nbTraitement');

        $arg1 = $arg1 ?? 5;

        for($i=1;$i<=$arg1;$i++){
            $io->note('Traitement '.$i.' en cours...');
            $this->bus->dispatch(new Traitement(rand(5,15)));
        }

        $io->success('Traitement terminé.');

        return Command::SUCCESS;
    }
}
