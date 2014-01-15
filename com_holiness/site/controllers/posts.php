<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');



class HolinessControllerPosts extends JController
{
    public function getplusones() {
        $user =& JFactory::getUser();
        $model =& $this->getModel('posts');
        $id = JRequest::getVar('id', '', 'get', 'int');
        $type = JRequest::getVar('tp', '', 'get', 'string');
        
        if ($type == 'prayerrequest') {
            $plusones = $model->getWillprays($id);
        }
        else {
            $plusones = $model->getPlusones($id, $type);
        }
        
        if ($plusones && count($plusones) > 0 && !$user->guest) {
            http_response_code(200);
            header('Content-type: application/json');
            
            echo json_encode($plusones);
        }
        else {
            http_response_code(404);
            header('Content-type: application/json');
            
            echo json_encode("[]");
        
        }
        
         exit();
    }
    
    
    
      
    public function ihaveprayed() {
        $model =& $this->getModel('posts');
        $comment = array();
        $data = $this->get_post_data();
        $user =& JFactory::getUser();
        
        if (is_object($data)) {
            $userid = $user->id;
            $postid = $data->postid;
        }
        elseif (is_array($data)) {
            $userid = $user->id;
            $postid = $data['postid'];
        }
        
        if (!$model->iHavePrayed($userid, $postid)) {
            $this->response(500, 'Not saved'); 
        }
        else {
            $this->response(200, 'Saved');
        }
        
        exit(); 
    }
    
    
    
      
    public function willpray() {
        $model =& $this->getModel('posts');
        $comment = array();
        $data = $this->get_post_data();
        $user =& JFactory::getUser();
        
        if (is_object($data)) {
            $userid = $user->id;
            $postid = $data->postid;
        }
        elseif (is_array($data)) {
            $userid = $user->id;
            $postid = $data['postid'];
        }
        
        if (!$model->willPray($userid, $postid)) {
            $this->response(500, 'Not saved'); 
        }
        else {
            $this->response(200, 'Saved');
        }
        
        exit(); 
    }
    
    
    
    public function plusone() {
        $model =& $this->getModel('posts');
        $comment = array();
        $data = $this->get_post_data();
        $user =& JFactory::getUser();
        
        if (is_object($data)) {
            $userid = $user->id;
            $postid = $data->postid;
            $post_type = $data->post_type;
        }
        elseif (is_array($data)) {
            $userid = $user->id;
            $post_type = $data['post_type'];
            $postid = $data['postid'];
        }
        
        if (!$model->plusOne($userid, $postid, $post_type)) {
            $this->response(500, 'Not saved'); 
        }
        else {
            $this->response(200, 'Saved');
        }
        
        exit(); 
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
    
    
    
    private function response ($code=200, $msg) {
        http_response_code($code);
        header('Content-type: application/json');
        
        echo '{"code":"' . $code . '","message":"' . $msg . '"}';
        
        exit();
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
