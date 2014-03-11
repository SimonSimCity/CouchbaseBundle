<?php

namespace Simonsimcity\CouchbaseBundle\Wrapper;


use Symfony\Component\Stopwatch\Stopwatch;

class Couchbase extends \Couchbase
{
    private $stopwatch;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        $hosts = array("localhost"),
        $user = "",
        $password = "",
        $bucket = "default",
        $persistent = true,
        Stopwatch $stopwatch
    ) {
        $this->stopwatch = $stopwatch;

        $e = $this->stopwatch->start('__construct', 'couchbase');
        parent::__construct($hosts, $user, $password, $bucket, $persistent);
        $e->stop();
    }

    private function call($method, $arguments = array())
    {
        switch ($method) {
            case "add":
            case "set":
            case "replace":
            case "prepend":
            case "append":
            case "get":
            case "getReplica":
            case "getAndLock":
            case "getAndTouch":
            case "unlock":
            case "touch":
            case "delete":
            case "increment":
            case "decrement":
            case "observe":
            case "keyDurability":
            case "setTimeout":
            case "getDesignDoc":
            case "setDesignDoc":
            case "deleteDesignDoc":
                $name = $method . ": " . $arguments[0];
                break;

            case "cas":
                $name = $method . ": " . $arguments[1];
                break;

            case "view":
            case "viewGenQuery":
                $name = $method . ": " . $arguments[0] . " - " . $arguments[1];
                break;

            case "setMulti":
                $name = $method . ": " . implode(", ", array_keys($arguments[0]));
                break;

            case "getMulti":
            case "getAndLockMulti":
            case "getAndTouchMulti":
            case "touchMulti":
            case "getDelayed":
            case "observeMulti":
            case "keyDurabilityMulti":
                $name = $method . ": " . sprintf("%d item(s)", array(count($arguments[0])));
                break;

            default:
                $name = $method;
        }

        $t = $this->stopwatch->start($name, 'couchbase');

        try {
            $result = call_user_func_array(array($this, "parent::{$method}"), $arguments);
        } catch (\Exception $e) {
            $t->stop();
            throw $e;
        }

        $t->stop();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    function add($id, $document, $expiry = 0, $persist_to = 0, $replicate_to = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function set($id, $document, $expiry = 0, $cas = "", $persist_to = 0, $replicate_to = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function replace($id, $document, $expiry = 0, $cas = "", $persist_to = 0, $replicate_to = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function prepend($id, $document, $expiry = 0, $cas = "", $persist_to = 0, $replicate_to = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function append($id, $document, $expiry = 0, $cas = "", $persist_to = 0, $replicate_to = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function cas($cas, $id, $document, $expiry = null)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function get($id, $callback = null, &$cas = "")
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function setMulti(array $documents, $expiry = 0, $persist_to = 0, $replicate_to = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getMulti(array $ids, array &$cas = array(), $flags = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    function getReplica($id, $strategy = COUCHBASE_REPLICA_FIRST)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getAndLock($id, &$cas = "", $expiry = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getAndLockMulti(array $ids, array &$cas = array(), $flags = 0, $expiry = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getAndTouchMulti(array $ids, $expiry = 0, array &$cas = array())
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getAndTouch($id, $expiry = 0, &$cas = "")
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function unlock($id, $cas)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function touch($id, $expiry)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function touchMulti(array $ids, $expiry)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    function delete($id, $cas = "", $persist_to = 0, $replicate_to = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function increment($id, $delta = 1, $create = false, $expire = 0, $initial = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function decrement($id, $delta = 1, $create = false, $expire = 0, $initial = 0)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function flush()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getDelayed(array $ids, $with_cas = false, $callback = null, $expiry = 0, $lock = false)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function fetch()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function fetchAll()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function view($document, $view = "", array $options = array(), $return_errors = false)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function viewGenQuery($document, $view = "", array $options = array(), $return_errors = false)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getStats() {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getResultCode() {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getResultMessage() {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function setOption($option, $value) {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getOption($option) {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getVersion($resource) {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getClientVersion() {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getNumReplicas() {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getServers() {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function observe($id, $cas, &$details = array())
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function observeMulti(array $ids, &$details = array())
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function keyDurability($id, $cas, array $details = array())
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function keyDurabilityMulti(array $ids, array $details = array())
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getTimeout()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function setTimeout($timeout)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function getDesignDoc($name)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function setDesignDoc($name, $document)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function deleteDesignDoc($name)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    function listDesignDocs()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }
}