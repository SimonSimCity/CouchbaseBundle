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
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function set($id, $document, $expiry = 0, $cas = "", $persist_to = 0, $replicate_to = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function replace($id, $document, $expiry = 0, $cas = "", $persist_to = 0, $replicate_to = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function prepend($id, $document, $expiry = 0, $cas = "", $persist_to = 0, $replicate_to = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function append($id, $document, $expiry = 0, $cas = "", $persist_to = 0, $replicate_to = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function cas($cas, $id, $document, $expiry = null)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function get($id, $callback = null, &$cas = "")
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function setMulti(array $documents, $expiry = 0, $persist_to = 0, $replicate_to = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getMulti(array $ids, array &$cas = array(), $flags = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    function getReplica($id, $strategy = COUCHBASE_REPLICA_FIRST)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getAndLock($id, &$cas = "", $expiry = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getAndLockMulti(array $ids, array &$cas = array(), $flags = 0, $expiry = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getAndTouchMulti(array $ids, $expiry = 0, array &$cas = array())
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getAndTouch($id, $expiry = 0, &$cas = "")
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function unlock($id, $cas)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function touch($id, $expiry)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function touchMulti(array $ids, $expiry)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    function delete($id, $cas = "", $persist_to = 0, $replicate_to = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function increment($id, $delta = 1, $create = false, $expire = 0, $initial = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function decrement($id, $delta = 1, $create = false, $expire = 0, $initial = 0)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function flush()
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getDelayed(array $ids, $with_cas = false, $callback = null, $expiry = 0, $lock = false)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function fetch()
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function fetchAll()
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function view($document, $view = "", array $options = array(), $return_errors = false)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function viewGenQuery($document, $view = "", array $options = array(), $return_errors = false)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getStats() {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getResultCode() {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getResultMessage() {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function setOption($option, $value) {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getOption($option) {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getVersion($resource) {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getClientVersion() {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getNumReplicas() {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getServers() {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function observe($id, $cas, &$details = array())
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function observeMulti(array $ids, &$details = array())
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function keyDurability($id, $cas, array $details = array())
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function keyDurabilityMulti(array $ids, array $details = array())
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getTimeout()
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function setTimeout($timeout)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function getDesignDoc($name)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function setDesignDoc($name, $document)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function deleteDesignDoc($name)
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    function listDesignDocs()
    {
	    $stack = debug_backtrace();
	    return $this->call(__FUNCTION__, $stack[0]["args"]);
    }
}