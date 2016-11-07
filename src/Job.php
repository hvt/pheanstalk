<?php

namespace Pheanstalk;

/**
 * A job in a beanstalkd server.
 *
 * @author  Paul Annesley
 * @package Pheanstalk
 * @license http://www.opensource.org/licenses/mit-license.php
 */
class Job
{
    const STATUS_READY = 'ready';
    const STATUS_RESERVED = 'reserved';
    const STATUS_DELAYED = 'delayed';
    const STATUS_BURIED = 'buried';

    private $_id;
    private $_data;
    private $_tube;

    /**
     * @param int    $id   The job ID
     * @param string $data The job data
     * @param string $tube Tube where the job came from (optional)
     */
    public function __construct($id, $data, $tube = null)
    {
        $this->_id = (int) $id;
        $this->_data = $data;
        $this->_tube = $tube;
    }

    /**
     * The job ID, unique on the beanstalkd server.
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * The job data.
     *
     * @return string
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * The job's tube.
     *
     * @return string
     */
    public function getTube()
    {
        return $this->_tube;
    }
}
