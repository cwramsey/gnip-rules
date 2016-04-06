<?php

require_once(__DIR__ . '/../vendor/autoload.php');

class RuleValidationTest extends PHPUnit_Framework_TestCase
{

    public function testValidRule()
    {
        $rule = [
            [
                'value' => 'abc',
                'tag'   => '123',
            ],
        ];

        $this->assertTrue(\Gnip\Models\RuleList::validateRawRuleFormat($rule),
                          'Asserts that a valid rule should return true');
    }

    public function testValidRuleMultiples()
    {
        $rule = [
            [
                'value' => 'abc',
                'tag'   => '123',
            ],
            [
                'value' => 'abc',
                'tag'   => '123',
            ],
            [
                'value' => 'abc',
                'tag'   => '123',
            ],
        ];

        $this->assertTrue(\Gnip\Models\RuleList::validateRawRuleFormat($rule),
                          'Asserts that multiple valid rules should return true');
    }

    public function testInvalidRule()
    {
        $rule = [
            [
                'badkey' => 'abc',
                'tag'   => '123',
            ],
        ];

        $this->assertFalse(\Gnip\Models\RuleList::validateRawRuleFormat($rule),
                          'Asserts that an invalid rule should return false');
    }

    public function testInvalidRuleFlatArray()
    {
        $rule = [
            'value' => 'abc',
            'tag'   => '123',
        ];

        $this->assertFalse(\Gnip\Models\RuleList::validateRawRuleFormat($rule),
                          'Asserts that an invalid rule should return false');
    }

    public function testValidNoTags() {
        $rule = [
            [
                'value' => 'abc'
            ]
        ];

        $this->assertTrue(\Gnip\Models\RuleList::validateRawRuleFormat($rule, false),
                           'Asserts that a valid rule, without tags, returns true');
    }

    public function testInvalidNoTags() {
        $rule = [
            [
                'badkey' => 'abc'
            ]
        ];

        $this->assertFalse(\Gnip\Models\RuleList::validateRawRuleFormat($rule, false),
                           'Asserts that an invalid rule, without tags, returns false');
    }

}
