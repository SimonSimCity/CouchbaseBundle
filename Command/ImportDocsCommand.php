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
                "path",
                InputArgument::OPTIONAL,
                "Where are your documents (*.json) located (relative to %kernel.root_dir%)?",
                "Resources/couchbase/"
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Absolute path to the design-documents
        $path = $this->getContainer()->getParameter('kernel.root_dir') . DIRECTORY_SEPARATOR
            . $input->getArgument("path");

        $couchbase = $this->getContainer()->get("couchbase");

        $res = $couchbase->view("sf2_couchbase_bundle", "get_all_docs", array("stale" => false));
        #var_dump($res);
        foreach ($res['rows'] as $data)
            $couchbase->delete($data['id']);

        $data = array();
        $dir = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        /** @var \SplFileInfo $node */
        foreach ($dir as $node) {
            if ($node->isFile() && $node->getExtension() === "json") {
                $data[$node->getBasename('.json')] = file_get_contents($node->getRealPath());
            }
        }

        if (!empty($data))
            $couchbase->setMulti($data);
    }
}
