<?php

declare(strict_types=1);

namespace App\Command;


use App\ProductImporterToDatabase\ProductImporterToMysqlDatabase;
use App\ProductsSpotter\ProductsSpotter;
use App\ToArrayConverter\CsvToArrayConverter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCsvToMysqlDatabaseCommand extends Command
{
    protected static $defaultName = 'app:import:csv:mysql';
    private CsvToArrayConverter $csvToArrayConverter;
    private ProductImporterToMysqlDatabase $productImporter;

    public function __construct(CsvToArrayConverter $csvToArrayConverter, ProductImporterToMysqlDatabase $productImporter)
    {
        $this->csvToArrayConverter = $csvToArrayConverter;
        $this->productImporter = $productImporter;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Import csv file data to the database.')
            ->setHelp('This command allows you to import csv file, which contains products to the database.')
            ->addArgument('filename', InputArgument::REQUIRED, 'The filename')
            ->addArgument('mode', InputArgument::REQUIRED, 'test or import mode')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        $mode = $input->getArgument('mode');
        if($mode === 'test' || $mode ==='import') {
            $data = $this->csvToArrayConverter->convert($filename);
            $productSpotter = new ProductsSpotter($data, $this->csvToArrayConverter->getConvertErrors());
            $data = $productSpotter->spotProducts();
            if($mode === 'import'){
                $this->productImporter->import($data);
            }
            $output->writeln($productSpotter->getStringErrors());
        }
        else{
            $output->writeln("Import mode need to be test or import");
        }
        return Command::SUCCESS;
    }
}
