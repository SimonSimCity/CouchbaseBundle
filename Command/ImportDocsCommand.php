<?php

namespace Simonsimcity\CouchbaseBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportDocsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("couchbase:import-docs")
            ->setDescription("Import documents found in a directory into your bucket")
            ->addArgument(
                "connection",
                InputArgument::REQUIRED,
                "The couchbase-connection this change should be applied to.",
                null
            )
            ->addArgument(
                "path",
                InputArgument::OPTIONAL,
                "Where are your documents (*.json) located (relative to %kernel.root_dir%)?",
                "Resources/couchbase/{connection}/"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Absolute path to the design-documents
        $path = $this->getContainer()->getParameter('kernel.root_dir').DIRECTORY_SEPARATOR
                .$input->getArgument("path");

        $path      = str_replace("{connection}", $input->getArgument('connection'), $path);
        $couchbase = $this->getContainer()->get("couchbase.bucket.{$input->getArgument('connection')}");
        /** @var \CouchbaseBucket $couchbase */

        $res = $couchbase->query(
            \CouchbaseViewQuery::from("sf2_couchbase_bundle", "get_all_docs")
                               ->stale(\CouchbaseViewQuery::UPDATE_BEFORE)
        );

        foreach ($res['rows'] as $data) {
            $couchbase->remove($data['id']);
        }

        $data = array();
        $dir  = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        $success = 0;
        /** @var \SplFileInfo $node */
        foreach ($dir as $node) {
            if ($node->isFile() && $node->getExtension() === "json") {
                $result = $couchbase->upsert($node->getBasename('.json'), file_get_contents($node->getRealPath()));

                if ( ! empty($result->error)) {
                    $output->writeln("<error>{$key} {$result->error}</error>");
                } else {
                    $success++;
                }
            }
        }

        $output->writeln("<info>{$success} documents created.</info>");
    }
}
