<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use BetterIni\Ini;
use Gnip\GnipRules;
use Gnip\Models\RuleList;
use Gnip\Models\Rule;

class GnipRulesTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function __construct()
    {
        $ini = new Ini(__DIR__ . '/config.test.ini');
        $this->client = new GnipRules($ini->get('gnip.username'),
                                      $ini->get('gnip.password'),
                                      $ini->get('gnip.account_name'),
                                      'twitter',
                                      $ini->get('gnip.stream_label'));

        parent::__construct();
    }

    public function testCreate() {
        $rule_value = 'chris-test-rule';

        $new_rules = [
            [
                'value' => $rule_value,
                'tag' => '31'
            ]
        ];

        $updated_rules = $this->client->create($new_rules);

        $does_contain = false;
        foreach($updated_rules as $rule) {
            if ($rule->getValue() === $rule_value) {
                $does_contain = true;
                break;
            }
        }

        $this->assertTrue($does_contain, 'Updated rules list contains new rule');
    }

    public function testRead()
    {
        $response = $this->client->read();
        $this->assertTrue($response instanceof RuleList, 'response is instance of RuleList');

        $rules = $response->getRules();
        $this->assertTrue($rules[0] instanceof Rule, 'first rule is an instance of Rule');
    }

    public function testDelete() {
        $rule_value = 'chris-test-rule';

        $rules_to_delete = [
            [
                'value' => $rule_value,
                'tag' => '31'
            ]
        ];

        $updated_rules = $this->client->delete($rules_to_delete);

        $does_contain = false;
        foreach($updated_rules as $rule) {
            if ($rule->getValue() === $rule_value) {
                $does_contain = true;
                break;
            }
        }

        $this->assertFalse($does_contain, 'Updated rules list does not contain rule we deleted');
    }
}
