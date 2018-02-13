<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: test.proto

namespace Tests;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * <pre>
 * A call to the form of DocumentRef.Update that represents the data as a list
 * of field paths and their values.
 * </pre>
 *
 * Protobuf type <code>tests.UpdatePathsTest</code>
 */
class UpdatePathsTest extends \Google\Protobuf\Internal\Message
{
    /**
     * <pre>
     * path of doc
     * </pre>
     *
     * <code>string doc_ref_path = 1;</code>
     */
    private $doc_ref_path = '';
    /**
     * <pre>
     * precondition in call, if any
     * </pre>
     *
     * <code>.google.firestore.v1beta1.Precondition precondition = 2;</code>
     */
    private $precondition = null;
    /**
     * <pre>
     * parallel sequences: field_paths[i] corresponds to json_values[i]
     * </pre>
     *
     * <code>repeated .tests.FieldPath field_paths = 3;</code>
     */
    private $field_paths;
    /**
     * <pre>
     * the argument values, as JSON
     * </pre>
     *
     * <code>repeated string json_values = 4;</code>
     */
    private $json_values;
    /**
     * <pre>
     * expected rquest
     * </pre>
     *
     * <code>.google.firestore.v1beta1.CommitRequest request = 5;</code>
     */
    private $request = null;
    /**
     * <pre>
     * call signals an error
     * </pre>
     *
     * <code>bool is_error = 6;</code>
     */
    private $is_error = false;

    public function __construct() {
        \GPBMetadata\Test::initOnce();
        parent::__construct();
    }

    /**
     * <pre>
     * path of doc
     * </pre>
     *
     * <code>string doc_ref_path = 1;</code>
     */
    public function getDocRefPath()
    {
        return $this->doc_ref_path;
    }

    /**
     * <pre>
     * path of doc
     * </pre>
     *
     * <code>string doc_ref_path = 1;</code>
     */
    public function setDocRefPath($var)
    {
        GPBUtil::checkString($var, True);
        $this->doc_ref_path = $var;
    }

    /**
     * <pre>
     * precondition in call, if any
     * </pre>
     *
     * <code>.google.firestore.v1beta1.Precondition precondition = 2;</code>
     */
    public function getPrecondition()
    {
        return $this->precondition;
    }

    /**
     * <pre>
     * precondition in call, if any
     * </pre>
     *
     * <code>.google.firestore.v1beta1.Precondition precondition = 2;</code>
     */
    public function setPrecondition(&$var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Firestore\V1beta1\Precondition::class);
        $this->precondition = $var;
    }

    /**
     * <pre>
     * parallel sequences: field_paths[i] corresponds to json_values[i]
     * </pre>
     *
     * <code>repeated .tests.FieldPath field_paths = 3;</code>
     */
    public function getFieldPaths()
    {
        return $this->field_paths;
    }

    /**
     * <pre>
     * parallel sequences: field_paths[i] corresponds to json_values[i]
     * </pre>
     *
     * <code>repeated .tests.FieldPath field_paths = 3;</code>
     */
    public function setFieldPaths(&$var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Tests\FieldPath::class);
        $this->field_paths = $arr;
    }

    /**
     * <pre>
     * the argument values, as JSON
     * </pre>
     *
     * <code>repeated string json_values = 4;</code>
     */
    public function getJsonValues()
    {
        return $this->json_values;
    }

    /**
     * <pre>
     * the argument values, as JSON
     * </pre>
     *
     * <code>repeated string json_values = 4;</code>
     */
    public function setJsonValues(&$var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->json_values = $arr;
    }

    /**
     * <pre>
     * expected rquest
     * </pre>
     *
     * <code>.google.firestore.v1beta1.CommitRequest request = 5;</code>
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * <pre>
     * expected rquest
     * </pre>
     *
     * <code>.google.firestore.v1beta1.CommitRequest request = 5;</code>
     */
    public function setRequest(&$var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Firestore\V1beta1\CommitRequest::class);
        $this->request = $var;
    }

    /**
     * <pre>
     * call signals an error
     * </pre>
     *
     * <code>bool is_error = 6;</code>
     */
    public function getIsError()
    {
        return $this->is_error;
    }

    /**
     * <pre>
     * call signals an error
     * </pre>
     *
     * <code>bool is_error = 6;</code>
     */
    public function setIsError($var)
    {
        GPBUtil::checkBool($var);
        $this->is_error = $var;
    }

}

