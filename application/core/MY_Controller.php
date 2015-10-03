<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $before_filter = array();
    public $after_filter = array();
    public $data;

    public function __construct()
    {
        parent::__construct();

        // set data
        $this->data = new stdClass();
        $this->data->styles = array();
        $this->data->scripts = array();
        $this->data->page_title = 'CodeIgniter Sample';

        // load parser
        $this->load->library('parser');
        // load layout
        $this->load->library('layout');
        // load log4php
        $this->load->library('log4php', '', 'logger');
        // define filter
        $this->before_filter[] = array(
            'action' => 'prologue_intercept'
        );
        $this->after_filter[] = array(
            'action' => 'query_log_intercept'
        );
        $this->after_filter[] = array(
            'action' => 'epilogue_intercept'
        );
    }

    protected function output_json($object = array() , $content_type = 'application/json')
    {
        $this->output->set_content_type($content_type)->set_output(json_encode($object));
    }
    /**
     * default before_filter
     */
    function prologue_intercept()
    {
        $method = $this->input->server('REQUEST_METHOD');
        $log = '[開始][' . $this->uri->ruri_string() . '][' . $method . ']' . PHP_EOL;
        switch ($method) {
        case 'GET':
            $parameters = $this->input->get();
            break;

        case 'POST':
            $parameters = $this->input->post();
            break;

        case 'PUT':
            $parameters = $this->input->put();
            break;

        case 'DELETE':
            $parameters = $this->input->delete();
            break;

        default:
            return;
        }

        $log.= '<RequestParameter>' . PHP_EOL;
        $log.= $this->format_parameter_for_log($parameters);

        $this->logger->info($log);
    }
    /**
     * default after_filter
     */
    function epilogue_intercept()
    {
        $log = '[終了][' . $this->uri->ruri_string() . '][' . $this->input->server('REQUEST_METHOD') . ']' . PHP_EOL;
        $output = $this->output->get_output();
        if (!empty($output) && $this->output->get_content_type() !== 'text/html') {
            $log.= '<ResponseBody>' . PHP_EOL;
            $log.= $output . PHP_EOL;
        }
        $this->logger->info($log);
    }
    /**
     * Logging Query
     */
    function query_log_intercept()
    {
        if (isset($this->db)) {
            $times = $this->db->query_times;
            foreach ($this->db->queries as $key => $query) {
                $sql = '[Query]' . $query . ', Execution Time: ' . $times[$key];
                $this->logger->debug(preg_replace('/\r\n|\r|\n/', ' ', $sql));
            }
        }
    }
    /**
     * Authentication
     */
    function authenticate_intercept()
    {
    }
    /**
     * Protection CSRF
     */
    function csrf_protection_intercept()
    {
    }
    /**
     * Format RequestParameter
     *
     * @return
     */
    private function format_parameter_for_log($parameters, $attr = NULL)
    {
        $log = '';
        if (array_values($parameters) === $parameters) {
            $i = 0;
            foreach ($parameters as $value) {
                if (is_array($value)) {
                    $log.= $this->format_parameter_for_log($value, $attr . '[' . $i++ . ']');
                }
                else {
                    $log.= $attr . '[' . $i++ . ']=' . $value . PHP_EOL;
                }
            }
        }
        else {
            $i = 0;
            foreach ($parameters as $key => $value) {
                if (is_array($value)) {
                    if (array_values($parameters) === $parameters) {
                        $log.= $this->format_parameter_for_log($value, $key . '[' . $i++ . ']');
                    }
                    else {
                        $log.= $this->format_parameter_for_log($value, $key);
                    }
                }
                else if ($value !== 0 || !empty($value)) {
                    if (!empty($attr)) {
                        $log.= $attr . '.';
                    }
                    $log.= $key . '=' . $value . PHP_EOL;
                }
            }
        }

        return $log;
    }
}
// End of MY_Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
