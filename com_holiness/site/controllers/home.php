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
    
    
    public function getpartnerrequests() {
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT id, userid FROM #__devotion_partners WHERE partnerid={$user->id} AND active=0 ";
        $db->setQuery($query); 

        $results = $db->loadObjectList();
        
        if (!$results) {
            $this->response(500, '{"error":"true", "message":"No requests were found"}');        
        }
        else {
            $this->response(200, json_encode($results));
        }
        
        exit();
    }
    
    
    public function partnerresponse() {
        $model =& $this->getModel('home');
        $user =& JFactory::getUser();
        $arr = array();
        $data = $this->get_post_data();
        
        if (is_object($data)) {
            $id = $data->id;
            $res = $data->res;
            $partnerid = $data->partnerid;
        }
        elseif (is_array($data)) {
            $id = $data['id'];
            $res = $data['res'];
            $partnerid = $data['partnerid'];
        }
        
        
        if ($res == 'ignore') {
            if (!$model->removePartner($id)) {
                $this->response(500, '{"error":"true", "message":"Failed to remove request"}');
            }
            else {
                $this->response(200, json_encode('{"error":"false", "message":"Partner request ignored"}'));
            }
        }
        elseif ($res == 'accept') {
            
            if (!$model->updatePartner($id, array('active'=>1))) {
                $this->response(500, '{"error":"true", "message":"Failed to update request"}');
            }
            else {
                
                if (!$model->addPartner(array('active'=>1, 'userid'=>$user->id, 'partnerid'=>$partnerid))) {
                    $this->response(500, '{"error":"true", "message":"Failed to insert new partner"}');
                }
                else {
                    $message = "$user->name has agreed to become your Devotion Partner. Login to http://www.holinesspage.com to be blessed by new your Devotion Partner.";
                    $this->eMail($partnerid, $user->name, "Holiness Page", $message);
                    
                    $this->response(200, json_encode('{"error":"false", "message":"Partner request accepted"}'));
                }
            } 
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


    public function addpartner() {
        $model =& $this->getModel('home');
        $user =& JFactory::getUser();
        $post = array();
        $data = $this->get_post_data();
        
        $post['userid'] = $user->id;
        $post['active'] = 0;
        
        if (is_object($data)) {
            $post['partnerid'] = $data->partnerid;
            
        }
        elseif (is_array($data)) {
            $post['partnerid'] = $data['partnerid'];
        }
        
        if (!$result = $model->addPartner($post)) {
            $this->response(500, json_encode(array('error'=>false, 'message'=>'Add Partner request not sent'))); 
        }
        else {
            $message = "$user->name wants to become your Devotion Partner. Login to http://www.holinesspage.com to add $user->name as your Devotion Partner.";
            $this->eMail($post['partnerid'], $user->name, "New Devotion Partner", $message); 
            
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
    
    
    private function eMail($receiverid, $sendername, $subject, $message) {
        $user =& JFactory::getUser($receiverid);
        
        $body = "Hi {$user->name}, \n\n";
        $body .= "{$message} \n\n\n";
        $body .= "Holiness Page";
        
        $result = JUtility::sendMail('info@holinesspage.com', 'Holiness Page', $user->email, $subject, $body);
        
        return $result;
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
