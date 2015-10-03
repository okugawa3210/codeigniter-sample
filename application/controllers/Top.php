<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        array_push($this->data->styles, array(
            'name' => 'top'
        ));
        array_push($this->data->scripts, array(
            'name' => 'top'
        ));
        $this->data->test = 'test';
        $this->layout->load('top');
    }
}
// End of Top class

/* End of file Top.php */
/* Location: ./application/controllers/Top.php */
