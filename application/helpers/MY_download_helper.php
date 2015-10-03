<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('split_force_download')) {
    function split_force_download($filename = '', $filepath = '', $set_mime = FALSE)
    {
        if ($filename === '' OR $filepath === '') {
            return;
        }

        if (FALSE === strpos($filename, '.')) {
            return;
        }
        // Set the default MIME type to send
        $mime = 'application/octet-stream';

        $x = explode('.', $filename);
        $extension = end($x);

        if ($set_mime === TRUE) {
            if (count($x) === 1 OR $extension === '') {
                /* If we're going to detect the MIME type,
                 * we'll need a file extension.
                */
                return;
            }
            // Load the mime types
            $mimes = & get_mimes();
            // Only change the default MIME if we can find one
            if (isset($mimes[$extension])) {
                $mime = is_array($mimes[$extension]) ? $mimes[$extension][0] : $mimes[$extension];
            }
        }
        // get PHP memory_limit
        $ini_max = trim(ini_get('memory_limit'));
        switch (strtolower($ini_max[strlen($ini_max) - 1])) {
        case 'g':
            $max_size = intval($ini_max * 1024 * 1024 * 1024);
            break;

        case 'm':
            $max_size = intval($ini_max * 1024 * 1024);
            break;

        case 'k':
            $max_size = intval($ini_max * 1024);
            break;

        default:
            $max_size = intval($ini_max);
        }
        $filesize = filesize($filepath);
        /* It was reported that browsers on Android 2.1 (and possibly older as well)
         * need to have the filename extension upper-cased in order to be able to
         * download it.
         *
         * Reference: http://digiblog.de/2011/04/19/android-and-the-download-file-headers/
        */
        if (count($x) !== 1 && isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/Android\s(1|2\.[01])/', $_SERVER['HTTP_USER_AGENT'])) {
            $x[count($x) - 1] = strtoupper($extension);
            $filename = implode('.', $x);
        }
        // Clean output buffer
        if (ob_get_level() !== 0 && @ob_end_clean() === FALSE) {
            @ob_clean();
        }
        // Generate the server headers
        header('Content-Type: ' . $mime);
        // IE8
        $CI = & get_instance();
        $CI->load->library('user_agent');
        $CI->logger->debug($CI->agent->browser() . ':' . $CI->agent->version());
        if ($CI->agent->is_browser('Internet Explorer') && $CI->agent->version() == '8.0') {
            header('Content-Disposition: attachment; filename=' . mb_convert_encoding($filename, 'SJIS-win', 'UTF-8'));
        }
        // OTHER
        else {
            header('Content-Disposition: attachment; filename=' . $filename . ';filename*=UTF-8\'\'' . rawurlencode($filename));
        }
        header('Expires: 0');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . $filesize);
        // Internet Explorer-specific headers
        if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
            header('Cache-Control: no-cache, no-store, must-revalidate');
        }

        header('Pragma: no-cache');
        // if filesize greater than max_memory_limit, split download
        if ($ini_max > 0 && $max_size < $filesize) {
            flush();
            $fp = fopen($filepath, 'rb');
            while (!feof($fp)) {
                echo fread($fp, 4096);
                flush();
            }
            fclose($fp);
            exit();
        }
        else {
            exit(file_get_contents($filepath));
        }
    }
}
