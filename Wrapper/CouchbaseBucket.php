<?php

namespace Simonsimcity\CouchbaseBundle\Wrapper;


use Symfony\Component\Stopwatch\Stopwatch;

class CouchbaseBucket extends \CouchbaseBucket
{
    private $stopwatch;
    private $bucket;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        \CouchbaseBucket $bucket,
        Stopwatch $stopwatch
    ) {
        $this->stopwatch = $stopwatch;
        $this->bucket = $bucket;
    }

    private function call($method, $arguments = array())
    {
        switch ($method) {
            case "enableN1ql":
            case "insert":
            case "upsert":
            case "replace":
            case "append":
            case "prepend":
            case "get":
            case "getAndTouch":
            case "getAndLock":
            case "getFromReplica":
            case "touch":
            case "counter":
            case "unlock":
            case "_view":
            case "_n1ql":
            // TODO: Find a way to report queries here.
            //case "query":
            case "setTranscoder":
                $name = $method . ": " .
                        (
                            is_array($arguments[0]) ?
                            implode(", ", array_keys($arguments[0])) :
                            $arguments[0]
                        );
                break;

            default:
                $name = $method;
        }

        $t = $this->stopwatch->start($name, 'couchbase');

        try {
            $result = call_user_func_array(array($this->bucket, $method), $arguments);
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
    public function manager() {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function enableN1ql($hosts) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function insert($ids, $val = NULL, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function upsert($ids, $val = NULL, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function replace($ids, $val = NULL, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function append($ids, $val = NULL, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function prepend($ids, $val = NULL, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($ids, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function get($ids, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAndTouch($id, $expiry, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAndLock($id, $lockTime, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function getFromReplica($id, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function touch($id, $expiry, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function counter($ids, $delta, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function unlock($ids, $options = array()) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function _view($queryObj) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function _n1ql($queryObj) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function query($query) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }

    /**
     * {@inheritdoc}
     */
    public function setTranscoder($encoder, $decoder) {
        $stack = debug_backtrace();
        return $this->call(__FUNCTION__, $stack[0]["args"]);
    }
}