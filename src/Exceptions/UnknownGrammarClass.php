<?php


namespace Dyrynda\Database\Exceptions;


class UnknownGrammarClass extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'Unknown Grammar Class, unable to define  Type.';
}
