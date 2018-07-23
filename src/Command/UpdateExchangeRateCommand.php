<?php
/**
 * Created by PhpStorm.
 * User: arky
 * Date: 6/28/18
 * Time: 5:27 PM
 */

namespace App\Command;

use App\Entity\ExchangeRate;
use App\Service\ExchangeRateParser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class UpdateExchangeRateCommand extends Command
{
    private $parser;

    private $em;

    public function __construct(EntityManagerInterface $em, ExchangeRateParser $parser)
    {
        $this->em = $em;

        $this->parser = $parser;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('rate:update')
            ->setDescription('Update currency rates')
            ->setHelp('Allows you to update exchange rate from CBU');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rateRepository = $this->em->getRepository(ExchangeRate::class);

        $rate = $rateRepository->find(1);

        if (empty($rate)) {
            $rate = new ExchangeRate();
        }

        $USD = $this->parser->getUSD();
        $EUR = $this->parser->getEUR();
        $RUB = $this->parser->getRUB();

        $rate->setEUR($EUR);
        $rate->setUSD($USD);
        $rate->setRUB($RUB);

        $this->em->persist($rate);

        $this->em->flush();

        $output->writeln('Success!');
    }
}
