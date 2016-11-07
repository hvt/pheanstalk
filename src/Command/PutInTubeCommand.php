<?php

namespace Pheanstalk\Command;

use Pheanstalk\Exception;

/**
 * The 'put-in-tube' command.
 * Inserts a job into the client's currently used tube.
 * @see UseCommand
 *
 * @author Paul Annesley
 * @package Pheanstalk
 * @license http://www.opensource.org/licenses/mit-license.php
 */
class PutInTubeCommand
    extends PutCommand
    implements \Pheanstalk\ResponseParser
{
    private $_tube;

    /**
     * Puts a job on the queue of a specified tube.
     * @param string $tube     Tube to put job in
     * @param string $data     The job data
     * @param int    $priority From 0 (most urgent) to 0xFFFFFFFF (least urgent)
     * @param int    $delay    Seconds to wait before job becomes ready
     * @param int    $ttr      Time To Run: seconds a job can be reserved for
     */
    public function __construct($tube, $data, $priority, $delay, $ttr)
    {
        $this->_tube = $tube;

        parent::__construct($data, $priority, $delay, $ttr);
    }

    /* (non-phpdoc)
     * @see Command::getCommandLine()
     */
    public function getCommandLine()
    {
        return sprintf(
            'put-in-tube %s %u %u %u %u',
            $this->_tube,
            $this->_priority,
            $this->_delay,
            $this->_ttr,
            $this->getDataLength()
        );
    }
}
