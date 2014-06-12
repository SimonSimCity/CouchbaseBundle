<?php

namespace Simonsimcity\CouchbaseBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportDdocCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("couchbase:export-ddoc")
            ->setDescription("Exports the design documents for your couchbase installation")
            ->addArgument(
                "connection",
                InputArgument::REQUIRED,
                "The couchbase-connection this change should be applied to.",
                null
            )
            ->addArgument(
                "path",
                InputArgument::OPTIONAL,
                "Where should your design documents (*.ddoc) be located (relative to %kernel.root_dir%)?",
                "Resources/couchbase/{connection}/"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Absolute path to the design-documents
        $path = $this->getContainer()->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR
            . $input->getArgument("path");

        $path = str_replace("{connection}", $input->getArgument('connection'), $path);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $couchbase = $this->getContainer()->get("couchbase.{$input->getArgument('connection')}");
        /** @var \Couchbase $couchbase */

        // Remove all .ddoc files in the directory
        $iterator = new \DirectoryIterator($path);
        /** @var \SplFileInfo $fileInfo */
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile() && $fileInfo->getExtension() === "ddoc") {
                unlink($fileInfo->getRealPath());
            }
        }

        $res = json_decode($couchbase->listDesignDocs(), true);
        foreach ($res['rows'] as $ddoc) {

            $ddocId = $ddoc['doc']['meta']['id'];
            if (strpos($ddocId, "_design/") !== 0) {
                $output->writeln("<comment>Unknown document-type: {$ddocId}</comment>");
                continue;
            }

            $ddocName = substr($ddocId, 8);
            if (strpos($ddocName, "dev_") === 0) {
                $output->writeln("<comment>Skip dev-ddoc: {$ddocName}</comment>", OutputInterface::VERBOSITY_VERBOSE);
                continue;
            }

            $ddocContent = json_encode($ddoc['doc']['json']);
            file_put_contents($path . $ddocName . ".ddoc", $ddocContent);
            $output->writeln("<info>Exported: {$ddocName}</info>");
        }
    }
}
