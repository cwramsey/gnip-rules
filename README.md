## Introduction

This is a simple library for interacting with the [GNIP Powertrack rules API](http://support.gnip.com/apis/powertrack/api_reference.html).

## Installation

Run `$ composer require cwramsey/gnip-rules`

## Usage

#### Creating a client


```php
require_once(__DIR__ . '/vendor/autoload.php');

use Gnip\GnipRules;

$username = '';
$password = '';
$gnip_account_name = 'your_account_name';
$data_source = 'twitter';
$stream_label = 'stream_name';

$client = new GnipRules($username, $password, $gnip_account_name, $data_source, $stream_label);

```

#### Reading your rules

```php
$rules = $client->read(); // returns a Gnip\RuleList iterable with your full rule list.

foreach ($rules as $rule) {
	echo $rule->getValue() . " - " . $rule->getTag();
}

```

#### Creating new rules

```php
$new_rules = [
	[
    	'value' => 'rule1',
        'tag' => '123'
    ],
	[
    	'value' => 'rule2',
        'tag' => '123'
    ],
	[
    	'value' => 'rule3',
        'tag' => '123'
    ],
];

$updated_rules = $client->create($new_rules); // returns a GnipRuleList iterable with updated rules
```

#### Deleting rules

```php
$rules_to_delete = [
	[
    	'value' => 'rule1',
    ],
	[
    	'value' => 'rule2',
    ],
	[
    	'value' => 'rule3',
    ],
]; // please note that Gnip does not allow you to delete by tag, so you must only include the `value`.

$updated_rules = $client->delete($rules_to_delete); // returns a GnipRuleList iterable with updated rules
```

## TODO

* Add data collector support
* Add support for PowerTrack 2.0