<?php

namespace SimonSimCity\CouchbaseBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportDdocCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("couchbase:import-ddoc")
            ->setDescription("Import the design documents for your couchbase installation")
            ->addArgument(
                "path",
                InputArgument::OPTIONAL,
                "Where are your design documents (*.ddoc) located (relative to %kernel.root_dir%)?",
                "Resources/couchbase/"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Absolute path to the design-documents
        $path = $this->getContainer()->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR
            . $input->getArgument("path");

        $couchbase = $this->getContainer()->get("couchbase");
        /** @var \Couchbase $couchbase */
        try {
            $iterator = new \DirectoryIterator($path);
            /** @var \SplFileInfo $fileInfo */
            foreach ($iterator as $fileInfo) {
                if ($fileInfo->isFile() && $fileInfo->getExtension() === "ddoc") {

                    $res = $couchbase->setDesignDoc(
                        $fileInfo->getBasename(".ddoc"),
                        file_get_contents($fileInfo->getRealPath())
                    );

                    if ($res === true)
                        $output->writeln("<info>Created: ".$fileInfo->getBasename(".ddoc") . "</info>");
                    else
                        $output->writeln("<comment>Not created: ".$fileInfo->getBasename(".ddoc") . "</comment>");
                }
            }
        } catch(\CouchbaseException $e) {
            $output->writeln("<error>An error occurred while writing data to couchbase:</error>");
            $output->writeln("<error>{$e->getMessage()}</error>");
        }
    }
}
