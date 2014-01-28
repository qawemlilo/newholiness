<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');



class HolinessControllerDevotion extends JController
{
    public function getdevotions() {
        $user =& JFactory::getUser();
        $model =& $this->getModel('devotion');
        $id = JRequest::getVar('id', '', 'get', 'int');
        
        $devotions = $model->getDevotions($id);
        
        if ($devotions && count($devotions) > 0 && !$user->guest) {
            http_response_code(200);
            header('Content-type: application/json');
            
            echo json_encode($devotions);
        }
        else {
            http_response_code(404);
            header('Content-type: application/json');
            
            echo json_encode("[]");
        
        }
        
        exit();
    }
    
    
    
    public function unpublish() {
        $user =& JFactory::getUser();
        $application =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $model =& $this->getModel('devotion');
        $id = JRequest::getVar('id', '', 'get', 'int');
        
        if ($user->authorize( 'com_content', 'edit', 'content', 'all')) {
            $model->unpublish($id);
        }
        
        $application->redirect($refer, 'Done!');
    }
    
    

    public function create() {
		$user = array();
	    $user['fullname'] = JRequest::getVar('fullname', '', 'post', 'string');
		$user['email'] = JRequest::getVar('email', '', 'post', 'string');
		$user['username'] = JRequest::getVar('username', '', 'post', 'string');
		$password = JRequest::getVar('password', '', 'post', 'string');
        
        $password = $this->makeCrypt($password);
		
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
	        $this->response(200, 'Account created, please login.');
		}
        else {   
	        $this->response(500, 'Error. Account not created.');	
        }			
    }
    
    
    
    public function save() {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        
        $model =& $this->getModel('devotion');
        $application =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $arr = array();
        
	$book = JRequest::getVar('book', '', 'post', 'string');
        $chapter = JRequest::getVar('chapter', '', 'post', 'int');
        $verse = JRequest::getVar('verse', '', 'post', 'int');
        
	$arr['theme'] = JRequest::getVar('theme', '', 'post', 'string');
        $arr['scripture'] = $this->makeScripture($book, $chapter, $verse);
        $arr['memberid'] = JRequest::getVar('memberid', '', 'post', 'int');
        $arr['published'] = 1;
        $arr['devotion'] = JRequest::getVar('devotion', '', 'post', 'string');
        $arr['reading'] = JRequest::getVar('reading', '', 'post', 'string');
        $arr['bible'] = JRequest::getVar('bible', '', 'post', 'string');
        $arr['prayer'] = JRequest::getVar('prayer', '', 'post', 'string');
        
        if (!$model->create($arr)) {
            $application->redirect($refer, 'Devotion could not be saved', 'error');
        }
        else {
            $application->redirect($refer, 'Devotion saved', 'success');
        }
    }
    
    
    
    public function edit() {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        
        $model =& $this->getModel('devotion');
        $application =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $arr = array();
        
	$book = JRequest::getVar('book', '', 'post', 'string');
        $chapter = JRequest::getVar('chapter', '', 'post', 'int');
        $verse = JRequest::getVar('verse', '', 'post', 'int');
        
        $id = JRequest::getVar('devotionid', '', 'post', 'int');
        
	$arr['theme'] = JRequest::getVar('theme', '', 'post', 'string');
        $arr['scripture'] = $this->makeScripture($book, $chapter, $verse);
        $arr['memberid'] = JRequest::getVar('memberid', '', 'post', 'int');
        $arr['devotion'] = JRequest::getVar('devotion', '', 'post', 'string');
        $arr['reading'] = JRequest::getVar('reading', '', 'post', 'string');
        $arr['bible'] = JRequest::getVar('bible', '', 'post', 'string');
        $arr['prayer'] = JRequest::getVar('prayer', '', 'post', 'string');
        
        if (!$model->update($id, $arr)) {
            $application->redirect($refer, 'Devotion could not be updated', 'error');
        }
        else {
            $application->redirect($refer, 'Devotion updated', 'success');
        }
    }
    
    
    
    private function makeScripture($book, $chapter, $verse) {
        return $book . ' ' . $chapter . ':' . $verse;
    }
    
    
    
    private function response ($code=200, $msg) {
        $arr = array('message'=>$msg);
        http_response_code($code);
        header('Content-type: application/json');
        
        echo json_encode($arr);
        
        exit();
    }
    
    
 
    public function download() {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=devotion.doc");

        $id = JRequest::getVar('id', '', 'get', 'int');
        $model = $this->getModel('devotion');
        $devotion = $model->getDevotion($id);
                
        if($devotion) {
            $output = "";
            $date = $this->formatTime($devotion->ts);
            
            $output .= "Dear friend, hear the voice of the Lord today: $devotion->scripture \n \n \n";
            $output .= "Pastor's name: \n$devotion->name \n \n";
            $output .= "Senior Pastor @ (Church/Ministry): \n$devotion->church \n \n";
            $output .= "Day: \n$date->day \n \n";
            $output .= "Date: \n$date->month $date->year \n \n";
            $output .= "Today's theme: \n$devotion->theme \n \n";
            $output .= "Today's scripture: \n$devotion->scripture \n \n";
            $output .= "The scripture reads as follows: \n$devotion->reading \n \n";
            $output .= "Bible translation used: \n$devotion->bible \n \n";
            $output .= "Today's devotion: \n$devotion->devotion \n \n";
            $output .= "Today's confession / prayer: \n$devotion->prayer \n \n \n \n";
            
            $output .= "HOLINESS PAGE: http://www.holinesspage.com \n";
            
            $output = utf8_encode($output);
            
            echo $output;
        }
        
        exit();
    }
    
    
    private function formatTime($ts) {
        $mydate =  new DateTime($ts . '');
        list($day, $month, $year) = explode(',', $mydate->format("l,d M,Y"));
        
        $result = new stdClass();
        $result->day = $day;
        $result->month = $month;
        $result->year = $year;
        
        return $result;
    }

    
    function emaildevotion() {
        $body = "";
        $from_name = JRequest::getVar('from_name', '', 'post', 'string');
        $from_email = JRequest::getVar('from_email', '', 'post', 'string');
        $to_name = JRequest::getVar('to_name', '', 'post', 'string');
        $to_email = JRequest::getVar('to_email', '', 'post', 'string');
        $msg = JRequest::getVar('msg', '', 'post', 'string');
        $theme = JRequest::getVar('theme', '', 'post', 'string');
        $url = JRequest::getVar('url', '', 'post', 'string');
        
        if(empty($from_name) || empty($from_email) || empty($to_name) || empty($to_email) || empty($msg)) {
             echo false;
        }
        else {
            $from = array($from_email, $from_name);
            $subject = "Dear {$to_name}, hear the voice of the Lord today.";
            
            $body .= "This devotion was shared with you by $from_name from the HOLINESS PAGE website. " ;
            $body .= $theme . ".\n";
            $body .= $msg . ".\n";
            $body .= "Please visit this page to read your message: " . $url;
            
            $mailsent = $this->sendMail($from, $to_email, $to_name, $subject, $body);
           
            if ($mailsent) {
                $this->response(200, 'Message sent!');;
            } else {
               $this->response(500, 'Message not sent');
            }
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
    
    
    private function sendMail($from, $to, $to_name, $subject, $message) {
        $body = "Hi {$to_name}, \n\n";
        $body .= "{$message} \n\n\n";
        $body .= "Holiness Page";
        
        $result = JUtility::sendMail($from, 'Holiness Page', $to, $subject, $body);
        
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
