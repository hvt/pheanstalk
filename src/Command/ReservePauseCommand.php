<?php

namespace Pheanstalk\Command;

use Pheanstalk\Response;

/**
 * The 'reserve-pause' command.
 *
 * Reserves/locks a ready job in a watched tube, and pauses the tube when the reservation was successful.
 *
 * @author  Harm van Tilborg
 * @package Pheanstalk
 * @license http://www.opensource.org/licenses/mit-license.php
 */
class ReservePauseCommand
    extends AbstractCommand
    implements \Pheanstalk\ResponseParser
{
    private $_delay;
    private $_timeout;

    /**
     * The delay value says how many seconds the tube where the reserved job came
     * from, should be paused.
     * 
     * A timeout value of 0 will cause the server to immediately return either a
     * response or TIMED_OUT.  A positive value of timeout will limit the amount of
     * time the client will block on the reserve request until a job becomes
     * available.
     *
     * @param int $delay
     * @param int $timeout
     */
    public function __construct($delay, $timeout = null)
    {
        $this->_delay = $delay;
        $this->_timeout = $timeout;
    }

    /* (non-phpdoc)
     * @see Command::getCommandLine()
     */
    public function getCommandLine()
    {
        return isset($this->_timeout) ?
            sprintf('reserve-with-timeout-pause %s %s', $this->_timeout, $this->_delay) :
            sprintf('reserve-pause %s', $this->_delay);
    }

    /* (non-phpdoc)
     * @see ResponseParser::parseResponse()
     */
    public function parseResponse($responseLine, $responseData)
    {
        if (in_array($responseLine, array(Response::RESPONSE_DEADLINE_SOON, Response::RESPONSE_TIMED_OUT), true)) {
            return $this->_createResponse($responseLine);
        }

        list($code, $tube, $id) = explode(' ', $responseLine);

        return $this->_createResponse($code, array(
            'id'      => (int) $id,
            'tube'    => $tube,
            'jobdata' => $responseData,
        ));
    }
}
