<?php namespace Indatus\Callbot\Factories;

use Indatus\Callbot\Config;
use Indatus\Callbot\Services\ResultsHandlers\TwilioResultsHandler;

class ResultsHandlerFactory
{
     /**
     * Create a ResultsHandlerInterface implementation
     *
     * @param string $default
     *
     * @return ResultsHandler
     */
    public function make($default)
    {
        $connection = Config::getConnection('callservice', $default);

        switch ($connection['driver']) {
            case 'twilio':
                return new TwilioResultsHandler;
                break;
        } // @codeCoverageIgnore
    } // @codeCoverageIgnore
}