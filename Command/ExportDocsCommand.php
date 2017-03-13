<?php

namespace Simonsimcity\CouchbaseBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportDocsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("couchbase:export-docs")
            ->setDescription("Export documents found in your bucket to a directory")
            ->addArgument(
                "connection",
                InputArgument::REQUIRED,
                "The couchbase-connection this change should be applied to.",
                null
            )
            ->addArgument(
                "path",
                InputArgument::OPTIONAL,
                "Where will your documents (*.json) be located (relative to %kernel.root_dir%)?",
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

        foreach ($res->rows as $data) {
            file_put_contents($path.$data->id.".json", $couchbase->get($data->id)->value);
        }
    }
}
