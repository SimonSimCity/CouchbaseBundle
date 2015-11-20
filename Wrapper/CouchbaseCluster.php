<?php

namespace Simonsimcity\CouchbaseBundle\Wrapper;

use Symfony\Component\Stopwatch\Stopwatch;

class CouchbaseCluster extends \CouchbaseCluster
{
    private $stopwatch;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        $dsn = array("http://localhost/"),
        $user = "",
        $password = "",
        Stopwatch $stopwatch
    ) {
        $this->stopwatch = $stopwatch;

        $e = $this->stopwatch->start('__construct', 'couchbase');
        parent::__construct($dsn, $user, $password);
        $e->stop();
    }

    /**
     * {@inheritdoc}
     */
    function openBucket($name = 'default', $password = '')
    {
        $t = $this->stopwatch->start($name, 'couchbase');

        try {
            $result = parent::openBucket($name, $password);
        } catch (\Exception $e) {
            $t->stop();
            throw $e;
        }

        $t->stop();

	    return new CouchbaseBucket($result, $this->stopwatch);
    }
}