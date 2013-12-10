<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');


class HolinessControllerHome extends JController
{
    public function handlepost() {
        $model =& $this->getModel('home');
        $post = array();
        $data = $this->get_post_data();
        
        if (is_object($data)) {
            $post['userid'] = $data->userid;
            $post['post_type'] = $data->posttype;
            $post['post'] = $data->post;
        }
        elseif (is_array($data)) {
            $post['userid'] = $data['userid'];
            $post['post_type'] = $data['posttype'];
            $post['post'] = $data['post'];
        }
        
        if (empty($post['userid']) || empty($post['post_type']) || empty($post['post']) || !$result = $model->create($post)) {
            $this->response(500, json_encode($post)); 
        }
        else {
            $this->response(200, json_encode($result));
        }
        
        exit();
    }
    
    
    public function handleget() {
        $model =& $this->getModel('home');
        
        if (!$posts = $model->getTimeline()) {
            $this->response(500, '{"error":"true", "message":"No posts were found"}');        
        }
        else {
            $this->response(200, json_encode($posts));
        }
        
        exit();
    }


    public function handlepostitem() {
        $model =& $this->getModel('home');
        $post = array();
        $data = $this->get_post_data();
        
        
        if (is_object($data)) {
            $id = $data->id;
            $post['post'] = $data->post;
            
        }
        elseif (is_array($data)) {
            $id = $data['id'];
            $post['post'] = $data['post'];
        }
        
        if (!$id || !$result = $model->update($id, $post)) {
            $this->response(500, json_encode(array('error'=>false, 'message'=>'Item not updated'))); 
        }
        else {
            $this->response(200, json_encode($result));
        }
        
        exit();     
    }


    public function handleput() {
        $model =& $this->getModel('home');
        $post = array();
        $data = $this->get_post_data();
        
        
        if (is_object($data)) {
            $id = $data->id;
            $post['post'] = $data->post;
            
        }
        elseif (is_array($data)) {
            $id = $data['id'];
            $post['post'] = $data['post'];
        }
        
        if (!$id || !$result = $model->update($id, $post)) {
            $this->response(500, json_encode(array('error'=>false, 'message'=>'Item not updated'))); 
        }
        else {
            $this->response(200, json_encode($result));
        }
        
        exit();     
    }


    public function handledelete() {
        $model =& $this->getModel('home');
        $post = array();
        $data = $this->get_post_data();
        
        if (is_object($data)) {
            $id = $data->id;
        }
        elseif (is_array($data)) {
            $id = $data['id'];
        }
        
        if (!$id || !$result = $model->remove($id)) {
            $this->response(500, json_encode(array('error'=>false, 'message'=>'Item not deleted'))); 
        }
        else {
            $this->response(200, json_encode($result));
        }
        
        exit();     
    }
    
    

    private function response ($code=200, $json) {
        http_response_code($code);
        header('Content-type: application/json');
        
        echo $json;
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
