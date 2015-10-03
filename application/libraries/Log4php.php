<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log4php
{
    private $logger;

    public function __construct()
    {
        Logger::configure(APPPATH . 'config/log4php.properties');
        $this->logger = Logger::getLogger('AppLog');
    }

    public function trace($message, $throwable = null)
    {
        $this->logger->trace($message, $throwable);
    }

    public function debug($message, $throwable = null)
    {
        $this->logger->debug($message, $throwable);
    }

    public function info($message, $throwable = null)
    {
        $this->logger->info($message, $throwable);
    }

    public function warn($message, $throwable = null)
    {
        $this->logger->warn($message, $throwable);
    }

    public function error($message, $throwable = null)
    {
        $this->logger->error($message, $throwable);
    }

    public function fatal($message, $throwable = null)
    {
        $this->logger->fatal($message, $throwable);
    }
}
// End of Log4php class

/* End of file Log4php.php */
/* Location: ./application/libraries/Log4php.php */
