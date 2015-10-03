<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout
{
    private $CI;
    private $directory = 'layouts';
    private $layout = 'base';
    private $is_template = TRUE;

    public function __construct($config = array())
    {
        $this->CI = & get_instance();
        empty($config) OR $this->initialize($config);
    }

    public function initialize(array $config = array())
    {
        set_config($config);
    }

    public function set_config($config = array())
    {
        $reflection = new ReflectionClass($this);
        $defaults = $reflection->getDefaultProperties();

        foreach (array_keys($defaults) as $key) {
            if ($key[0] === '_') {
                continue;
            }

            if (isset($config[$key])) {
                if ($reflection->hasMethod('set_' . $key)) {
                    $this->{'set_' . $key}($config[$key]);
                }
                else {
                    $this->$key = $config[$key];
                }
            }
            else {
                $this->$key = $defaults[$key];
            }
        }
    }

    public function set_directory($directory)
    {
        $this->directory = $directory;
        return this;
    }

    public function set_layout($layout)
    {
        $this->layout = $layout;
        return this;
    }

    public function set_is_template($is_template)
    {
        $this->is_template = $is_template;
        return this;
    }

    function load($content = null, $data = null, $is_template = TRUE)
    {
        if (is_null($data))
        {
            $data = $this->CI->data;
        }

        if (!is_null($content)) {

            if (!file_exists(VIEWPATH . $content . '.php') && !file_exists(VIEWPATH . $content)) {
                show_error('Unable to load the requested file: ' . VIEWPATH . $content . '.php');
            }

            if ($is_template) {
                $content = $this->CI->parser->parse($content, $data, TRUE);
            }
            else {
                $content = $this->CI->load->view($content, $data, TRUE);
            }

            $data->content = $content;
        }
        if ($this->is_template) {
            $this->CI->parser->parse($this->directory . '/' . $this->layout, $data);
        }
        else {
            $this->CI->load->view($this->directory . '/' . $this->layout, $data);
        }
    }
}
// End of Layout class

/* End of file Layout.php */
/* Location: ./application/libraries/Layout.php */
