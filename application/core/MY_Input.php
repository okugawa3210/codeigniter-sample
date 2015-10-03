<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Input extends CI_Input
{
    private function parse_str($raw_input_stream, $convert = array())
    {
        foreach (explode('&', $raw_input_stream) as $query) {
            if (!empty($query)) {
                $keyValue = explode('=', $query);
                $key = $keyValue[0];
                $value = urldecode($keyValue[1]);

                $this->_parse_str($key, $value, $convert);
            }
        }

        return $convert;
    }

    private function _parse_str($key, $value, &$convert)
    {
        if (preg_match('/(.*)\[(\d+)\](\.(.*))?/', $key, $matches)) {
            if (!array_key_exists($matches[1], $convert)) {
                $convert[$matches[1]] = array();
            }
            if (is_null($matches[3])) {
                $convert[$matches[1]][$matches[2]] = $value;
            }
            else {
                if (!array_key_exists($matches[2], $convert[$matches[1]])) {
                    $convert[$matches[1]][$matches[2]] = array();
                }
                $this->_parse_str($matches[4], $value, $convert[$matches[1]][$matches[2]]);
            }
        }
        else {
            $convert[$key] = $value;
        }
    }

    public function input_stream($index = NULL, $xss_clean = NULL)
    {
        // Prior to PHP 5.6, the input stream can only be read once,
        // so we'll need to check if we have already done that first.
        if (!is_array($this->_input_stream)) {
            // $this->raw_input_stream will trigger __get().
            // parse_str($this->raw_input_stream, $this->_input_stream);
            $this->_input_stream = $this->parse_str($this->raw_input_stream);
            is_array($this->_input_stream) OR $this->_input_stream = array();
        }

        return $this->_fetch_from_array($this->_input_stream, $index, $xss_clean);
    }

    public function post($name = NULL, $xss_clean = NULL)
    {
        return $this->input_stream($name);
    }

    public function put($name = NULL)
    {
        return $this->input_stream($name);
    }

    public function delete($name = NULL)
    {
        return $this->input_stream($name);
    }

    public function patch($name = NULL)
    {
        return $this->input_stream($name);
    }
}
// End of MY_Input class

/* End of file MY_Input.php */
/* Location: ./application/core/MY_Input.php */
