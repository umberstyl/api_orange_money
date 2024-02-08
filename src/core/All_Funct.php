<?php


class All_Funct
{
    /**
     * functions orange_money_cashin  
     * @author Bernard baudouin um
     * @link     
     * @version 1.0.2 
     */


    /* ------------------------------- */
    /* Core */
    /* ------------------------------- */

    /**
     * check_system_requirements
     * 
     * @return array
     */
    function check_system_requirements()
    {
        /* init errors */
        $errors = [];
        /* set required php version*/
        $required_php_version = '8.0';
        /* check php version */
        if (version_compare($required_php_version, PHP_VERSION, '>=')) {
            $errors['PHP'] = true;
        }

        /* check if curl enabled */
        if (!extension_loaded('curl') || !function_exists('curl_init')) {
            $errors['curl'] = true;
        }
        /* check if mbstring enabled */
        if (!extension_loaded('mbstring')) {
            $errors['mbstring'] = true;
        }
        /* check if gd enabled */
        if (!extension_loaded('gd') || !function_exists('gd_info')) {
            $errors['gd'] = true;
        }
        /* check if mbstring enabled */
        if (!extension_loaded('mbstring')) {
            $errors['mbstring'] = true;
        }
        /* check if zip enabled */
        if (!extension_loaded('zip')) {
            $errors['zip'] = true;
        }
        /* check if allow_url_fopen enabled */
        if (!ini_get('allow_url_fopen')) {
            $errors['allow_url_fopen'] = true;
        }
        /* check if htaccess exist */
        if (!file_exists(ABSPATH . '.htaccess')) {
            $errors['htaccess'] = true;
        }
        /* check if config writable */
        if (!is_writable(ABSPATH . 'includes/config-example.php')) {
            $errors['config'] = true;
        }
        /* return */
        return $errors;
    }

    /**
     * get_system_protocol
     * 
     * @return string
     */
    function get_system_protocol()
    {
        $is_secure = false;
        if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
            $is_secure = true;
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
            $is_secure = true;
        }
        return $is_secure ? 'https' : 'http';
    }


    /**
     * redirect
     * 
     * @param string $url
     * @return void
     */
    function redirect($url = '')
    {
        if ($url) {
            header('Location: ' . SYS_URL . $url);
        } else {
            header('Location: ' . SYS_URL);
        }
        exit;
    }
    /**
     * reload
     * 
     * @return void
     */
    function reload()
    {
        header("Refresh:0");
        exit;
    }

    /* ------------------------------- */
    /* Security */
    /* ------------------------------- */

    /**
     * secure
     * 
     * @param string $value
     * @param string $type
     * @param boolean $quoted
     * @return string
     */

    function secure($value, $type = "", $quoted = true)
    {
        global $db;
        if (isset($value) && $value != 'null') {
            // [1] Sanitize
            /* Convert all applicable characters to HTML entities */
            $value = htmlentities($value, ENT_QUOTES, 'utf-8');
            // [2] Safe SQL
            //$value = $db->real_escape_string($value);
            switch ($type) {
                case 'int':
                    $value = ($quoted) ? "'" . floatval($value) . "'" : floatval($value);
                    break;
                case 'datetime':
                    $value = ($quoted) ? "'" . set_datetime($value) . "'" : set_datetime($value);
                    break;
                case 'search':
                    if ($quoted) {
                        $value = (!is_empty($value)) ? "'%" . $value . "%'" : "''";
                    } else {
                        $value = (!is_empty($value)) ? "'%%" . $value . "%%'" : "''";
                    }
                    break;
                default:
                    $value = (!is_empty($value)) ? $value : "";
                    $value = ($quoted) ? "'" . $value . "'" : $value;
                    break;
            }
        } else {
            switch ($type) {
                case 'int':
                    $value = ($quoted) ? "'0'" : 0;
                    break;
                default:
                    $value = ($quoted) ? "''" : "";
                    break;
            }
        }
        return $value;
    }
    /**
     * is_empty
     * 
     * @param string $value
     * @return boolean
     */
    function is_empty($value)
    {
        if (isset($value)) {
            $hh = false;
            if (strlen(trim(preg_replace('/\xc2\xa0/', ' ', $value))) == 0) {
                $hh = true;
            }
            return $hh;
        } else {
            return true;
        }
    }

    /**
     * valid_email
     * 
     * @param string $email
     * @return boolean
     */
    function valid_email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * get_hash_key
     * 
     * @param integer $length
     * @param boolean $only_numbers
     * @return string
     */
    function get_hash_key($length = 8, $only_numbers = false)
    {
        $chars = ($only_numbers) ? '0123456789' : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);
        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }
        return $result;
    }

  
}
