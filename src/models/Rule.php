<?php

namespace Gnip\Models;


class Rule
{
    protected $value;
    protected $tag;

    function __construct(string $value, string $tag)
    {
        $this->value = $value;
        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }
}