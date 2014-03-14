<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');



class HolinessControllerAdmin extends JController
{
    public function createmember() {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        
        $application = JFactory::getApplication();
        $data = $this->get_post_data();
        $user = array();
        
        if (is_object($data)) {
            $user['fullname'] = $data->fullname;
            $user['email'] = $data->email;
            $user['sendemail'] = $data->sendemail;
        }
        elseif (is_array($data)) {
            $user['fullname'] = $data['fullname'];
            $user['email'] = $data['email'];
            $user['sendemail'] = $data['sendemail'];
        }

		$user['username'] = $this->genRandomPassword();
		$passwrd = $this->genRandomPassword(8);
        
        $password = $this->makeCrypt($passwrd);
		
		$instance = JUser::getInstance();		
		$config = JComponentHelper::getParams('com_users');
		$defaultUserGroup = $config->get('new_usertype', 2);
		$acl = JFactory::getACL();
		
		$instance->set('id', null);
		$instance->set('name', $user['fullname']);
		$instance->set('username', $user['username']);
		$instance->set('password', $password);
		$instance->set('email', $user['email']);
		$instance->set('usertype', 'deprecated');
		$instance->set('groups', array($defaultUserGroup));
		

        if ($instance->save()) {
            $credentials = array();
            $credentials['username'] = $user['username'];
            $credentials['password'] = $passwrd;
            
            if($user['sendemail']) {
                $this->eMail($user['fullname'], $user['email'], 'Account created', $passwrd);
            }
            
	        $this->response(200, json_encode(array('message'=>'Member account created', 'email'=>$user['email'], 'password'=>$passwrd)));
            
            
		}
        else {   
	        $this->response(500, json_encode(array('message'=>$instance->getError())));	
        }
        
        exit();
    }
    
    

    
    private function getSalt($password) {  
        $passwordarray = explode(":", $password);
		
		if (is_array($passwordarray)) {
            return $passwordarray[1];
        }
        
        return false;
    }
    
    
    
    
    private function makeCrypt($password, $salt = false) {
    
		if (!$salt) {
            $salt = JUserHelper::genRandomPassword(32);
        }
        
        $crypt = JUserHelper::getCryptedPassword($password, $salt);
        $crypted = $crypt.':'.$salt;
        
        return $crypted;
    }
    
    
    
    private function response ($code=200, $data) {
        http_response_code($code);
        header('Content-type: application/json');
        echo $data;
    }
    
    
    private function eMail($name, $email, $subject, $password) {
        $body = "Hi {$name}, \n\n";
        $body .= "Your Holiness Page account has been created.\n\n";
        $body .= "Email: {$email} \n";
        $body .= "Password: {$password} \n\n";
        $body .= "Please login and complete your registration. \n\n\n";
        $body .= "Holiness Page";
        
        $result = JUtility::sendMail('info@holinesspage.com', 'Holiness Page', $email, $subject, $body);
        
        return $result;
    }
    
    
    
    private function get_post_data() { 
        if ($input = file_get_contents("php://input")) { 

            if ($json_post = json_decode($input,true)) { 
                return $json_post; 
            }
            else { 
                parse_str($input, $variables); 
                
                return $variables; 
            } 
        } 
        
        return false; 
    }
    
    
    function genRandomPassword($length = 16) {
        $salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $len = strlen($salt);
        $makepass = '';
     
        $stat = @stat(__FILE__);
        if(empty($stat) || !is_array($stat)) $stat = array(php_uname());
     
        mt_srand(crc32(microtime() . implode('|', $stat)));
     
        for ($i = 0; $i < $length; $i ++) {
            $makepass .= $salt[mt_rand(0, $len -1)];
        }
     
        return $makepass;
    }
}


if (!function_exists('http_response_code')) {
    function http_response_code($code = NULL) {
        if ($code !== NULL) {

            switch ($code) {
                case 100: $text = 'Continue'; break;
                case 101: $text = 'Switching Protocols'; break;
                case 200: $text = 'OK'; break;
                case 201: $text = 'Created'; break;
                case 202: $text = 'Accepted'; break;
                case 203: $text = 'Non-Authoritative Information'; break;
                case 204: $text = 'No Content'; break;
                case 205: $text = 'Reset Content'; break;
                case 206: $text = 'Partial Content'; break;
                case 300: $text = 'Multiple Choices'; break;
                case 301: $text = 'Moved Permanently'; break;
                case 302: $text = 'Moved Temporarily'; break;
                case 303: $text = 'See Other'; break;
                case 304: $text = 'Not Modified'; break;
                case 305: $text = 'Use Proxy'; break;
                case 400: $text = 'Bad Request'; break;
                case 401: $text = 'Unauthorized'; break;
                case 402: $text = 'Payment Required'; break;
                case 403: $text = 'Forbidden'; break;
                case 404: $text = 'Not Found'; break;
                case 405: $text = 'Method Not Allowed'; break;
                case 406: $text = 'Not Acceptable'; break;
                case 407: $text = 'Proxy Authentication Required'; break;
                case 408: $text = 'Request Time-out'; break;
                case 409: $text = 'Conflict'; break;
                case 410: $text = 'Gone'; break;
                case 411: $text = 'Length Required'; break;
                case 412: $text = 'Precondition Failed'; break;
                case 413: $text = 'Request Entity Too Large'; break;
                case 414: $text = 'Request-URI Too Large'; break;
                case 415: $text = 'Unsupported Media Type'; break;
                case 500: $text = 'Internal Server Error'; break;
                case 501: $text = 'Not Implemented'; break;
                case 502: $text = 'Bad Gateway'; break;
                case 503: $text = 'Service Unavailable'; break;
                case 504: $text = 'Gateway Time-out'; break;
                case 505: $text = 'HTTP Version not supported'; break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
            }

            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

            header($protocol . ' ' . $code . ' ' . $text);

            $GLOBALS['http_response_code'] = $code;
        } else {
            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
        }
        
        return $code;
    }
}
