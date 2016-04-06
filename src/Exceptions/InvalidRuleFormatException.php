<?php
/**
 * Created by PhpStorm.
 * User: chrisramsey
 * Date: 4/6/16
 * Time: 11:14 AM
 */

namespace Gnip\Exceptions;


use Gnip\Exceptions\GnipRuleException;

class InvalidRuleFormatException extends GnipRuleException
{
    const DEFAULT_MESSAGE = 'Your rule format was invalid. Valid format is [[value => "", tag => ""]]';
}