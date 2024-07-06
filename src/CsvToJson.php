<?php

namespace App;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CsvToJson extends Command
{

    public static function getDefaultName(): ?string
    {
        return "csvToJson";
    }

    protected function configure(): void
    {
        $this
            ->setDefinition(
                new InputDefinition([
                    new InputOption('input', '', InputOption::VALUE_REQUIRED, 'Input File Name'),
                    new InputOption('output', '', InputOption::VALUE_OPTIONAL, 'Output File Name'),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputFile = $input->getOption('input');
        $outputFile = $input->getOption('output');

        if (!file_exists($inputFile)) {
            $output->writeln('<error>File not exists</error>');

            return Command::FAILURE;
        }

        $contents = array_map("str_getcsv", file($inputFile));

        $header = array_shift($contents);

        $jsonData = [];

        foreach ($contents as $content) {

            $jsonData[] = array_combine($header, $content);
        }

        file_put_contents($outputFile, json_encode($jsonData, JSON_PRETTY_PRINT));
        $output->writeln('<info>File Compailed Successfully</info>');
        return Command::SUCCESS;
    }
}
