<?php
/**
 * Created by PhpStorm.
 * User: chrisramsey
 * Date: 4/1/16
 * Time: 11:13 AM
 */

namespace Gnip\Models;


class RuleList implements \Iterator
{
    protected $rules;

    public function __construct(array $rules)
    {
        $this->rules = array_map(function ($rule) {
            return new Rule($rule->value, $rule->tag);
        }, $rules);
    }

    /**
     * Checks that a rule is in a valid format we can understand
     * [[value => "", tag => ""]]
     *
     * @param      $rules
     * @param bool $require_tag
     *
     * @return bool
     */
    public static function validateRawRuleFormat($rules, $require_tag = true) {
        if (!is_array($rules)) {
            return false;
        }

        $valid_keys = ['value'];
        if ($require_tag) {
            $valid_keys[] = 'tag';
        }

        foreach ($rules as $rule) {
            if (!is_array($rule) || (count(array_intersect(array_keys($rule), $valid_keys)) !== count($valid_keys))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    public function current()
    {
        return current($this->rules);
    }

    public function next()
    {
        return next($this->rules);
    }

    public function key()
    {
        return key($this->rules);
    }

    public function valid()
    {
        $key = key($this->rules);
        return (isset($key) && $key !== false);
    }

    public function rewind()
    {
        reset($this->rules);
    }

}