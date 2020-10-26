<?php


namespace Dyrynda\Database\Exceptions;


class UnknownGrammarClass extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'Unknown grammar class, unable to define database type.';
}
