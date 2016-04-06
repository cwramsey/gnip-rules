<?php

namespace Gnip;

use Gnip\Models\RuleList;
use Gnip\Exceptions\InvalidRuleFormatException;
use GuzzleHttp\Client;

class GnipRules
{
    const MAX_RULES = 5000;
    const API_URI_FORMAT = 'https://api.gnip.com:443/accounts/%s/publishers/%s/streams/track/%s/rules.json';

    protected $auth;
    protected $stream_label;
    protected $data_source;
    protected $account_name;
    protected $api_url;

    /**
     * @param string $user
     * @param string $pass
     * @param string $account_name
     * @param string $data_source
     * @param string $stream_label
     */
    function __construct($user, $pass, $account_name, $data_source, $stream_label)
    {
        $this->auth = [$user, $pass];
        $this->account_name = $account_name;
        $this->data_source = $data_source;
        $this->stream_label = $stream_label;
        $this->api_url = sprintf(self::API_URI_FORMAT, $this->account_name, $this->data_source, $this->stream_label);
    }

    /**
     * @param array $rules
     *
     * @return RuleList
     * @throws InvalidRuleFormatException
     */
    public function create(array $rules):RuleList
    {
        if (!RuleList::validateRawRuleFormat($rules)) {
            throw new InvalidRuleFormatException();
        }

        $client = new Client();
        $client->post($this->api_url, [
            'auth'           => $this->auth,
            'decode_content' => 'gzip',
            'Content-Type'   => 'application/json',
            'body'           => json_encode([
                                                'rules' => $rules,
                                            ]),
        ]);

        return $this->read();
    }

    /**
     * @return RuleList
     */
    public function read():RuleList
    {
        $client = new Client();
        $res = $client->get($this->api_url, [
            'auth'           => $this->auth,
            'decode_content' => 'gzip',
            'Content-Type'   => 'application/json',
        ]);

        $rules = json_decode($res->getBody()->getContents());

        return new RuleList($rules->rules);
    }

    /**
     * @param array $rules
     *
     * @return RuleList
     * @throws InvalidRuleFormatException
     */
    public function delete(array $rules)
    {
        if (!RuleList::validateRawRuleFormat($rules, false)) {
            throw new InvalidRuleFormatException();
        }

        $client = new Client();
        $client->delete($this->api_url, [
            'auth'           => $this->auth,
            'decode_content' => 'gzip',
            'Content-Type'   => 'application/json',
            'body'           => json_encode([
                                                'rules' => $rules,
                                            ]),
        ]);

        return $this->read();
    }

}