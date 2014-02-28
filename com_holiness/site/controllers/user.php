<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
require_once(JPATH_COMPONENT . DS .'assets' . DS . 'includes' . DS .'resize-class.php');



class HolinessControllerUser extends JController
{
    public function me() {
        $user =& JFactory::getUser();
        $model =& $this->getModel('user');
        $partners = $model->getParners($user->id);
        
        if ($user->guest) {
            $this->response(500, json_encode(array('message'=>'Unauthorized user'))); 
        }
        else {
            $me = array(
                'id'=>$user->id,
                'name'=>$user->name,
                'username'=>$user->username,
                "baseUrl"=>JURI::base(),
                'email'=>$user->email,
                'partners'=>$partners
            );
            
            $this->response(200, json_encode($me));
        }
        
        exit();
    }


    public function addpartner() {
        $model = $this->getModel('user');
        $user = JFactory::getUser();
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
            $this->response(500, json_encode(array('message'=>'Add Partner request not sent'))); 
        }
        else {
            $message = "$user->name wants to become your Devotion Partner. Login to http://www.holinesspage.com to add $user->name as your Devotion Partner.";
            $this->eMail($post['partnerid'], $user->name, "New Devotion Partner", $message); 
            
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
            $this->response(500, json_encode(array('message'=>'No requests were found')));        
        }
        else {
            $this->response(200, json_encode($results));
        }
        
        exit();
    }
    
    
    public function partnerresponse() {
        $model = $this->getModel('user');
        $user = JFactory::getUser();
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
                $this->response(500, json_encode(array('message'=>'Failed to remove request')));
            }
            else {
                $this->response(200, json_encode(array('message'=>"Partner request ignored")));
            }
        }
        elseif ($res == 'accept') {
            if (!$model->updatePartner($id, array('active'=>1))) {
                $this->response(500, json_encode(array('message'=>'Failed to update request')));
            }
            else {
                $model->addPartner(array(
                    'active'=>1, 
                    'userid'=>$user->id, 
                    'partnerid'=>$partnerid
                ));
                $this->response(200, json_encode(array('message'=>'Partner added')));
            } 
        }
        
        exit();
    }
    
    
    
    /*
        Fetches all registered holiness page members
        First Checks if the user is logged
    */
    public function getusers() {
        $user =& JFactory::getUser();
        $model =& $this->getModel('user');
        $members = $model->getMembers();
        
        if ($members && count($members) > 0 && !$user->guest) {
            $this->response(200, json_encode($members));
        }
        else {
            $this->response(500, json_encode(array('message'=>"No data")));
        
        }
        
         exit();
    }
    
    

    /*
        Fetches a user's devotion partners
        Checks if the user is logged
        Extracts the user's id from the url
    */
    public function getpartners() {
        $user =& JFactory::getUser();
        $model =& $this->getModel('user');
        $id = JRequest::getVar('id', '', 'get', 'int');
        
        $partners = $model->getParners($id);
        
        if ($partners && count($partners) > 0 && !$user->guest) {
            $this->response(200, json_encode($partners));
        }
        else {
            $this->response(500, json_encode(array('message'=>'No data')));
        }
        
        exit();
    }
    
    
    
    /*
        Fetches all registered holiness page members
        First Checks if the user is logged
    */    
    public function getprofiles() {
        $user =& JFactory::getUser();
        $model =& $this->getModel('user');
        $members = $model->getProfiles();
        
        if ($members && count($members) > 0 && !$user->guest) {
            $this->response(200, json_encode($members));
        }
        else {
            $this->response(500, json_encode(array('message'=>'No data')));
        }
        
        exit();
    } 
    
    
    public function getuser() {
        $model =& $this->getModel('user');
        $name = JRequest::getVar('name', '', 'get', 'string');
        $member = $model->getUser($name);
        
        if ($member) {
            $this->response(200, json_encode($member));
        }
        else {
            $this->response(500, json_encode(array('message'=>'No data')));
        }
        
        exit();
        
    }
    

    public function create() {
        $application = JFactory::getApplication();
		$user = array();
	    $user['fullname'] = JRequest::getVar('fullname', '', 'post', 'string');
		$user['email'] = JRequest::getVar('email', '', 'post', 'string');
		$user['username'] = $this->genRandomPassword();
		$passwrd = JRequest::getVar('password', '', 'post', 'string');
        
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
            
            //perform the login action
            $application->login($credentials);
            
	        $this->response(200, json_encode(array('message'=>'Account created, please login.')));
		}
        else {   
	        $this->response(500, json_encode(array('message'=>$instance->getError())));	
        }
        
        exit();
    }
    
    
    
    public function createprofile() {
        //JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $model =& $this->getModel('user');
        $user =& JFactory::getUser();
        $member = array();
        $photoFolder = JPATH_SITE . DS . 'media' .  DS . 'com_holiness' . DS . 'images' . DS;
        

        
        $photo = JRequest::getVar('photo', null, 'files', 'array');
        $photofilename = JFile::makeSafe($photo['name']);
        $ext = strtolower(JFile::getExt($photofilename));

        $member['church'] = JRequest::getVar('church', '', 'post', 'string');
        $member['userid'] = $user->id;
        $member['imgext'] = $ext;
        
        $saved = $this->savePhoto($photo['tmp_name'], $photoFolder . $photofilename, $ext);
        
        if ($saved && $model->create($member)) {
            $this->resizeImages($photoFolder . $photofilename, $photoFolder, $ext, $user->id);
            $this->response(200, json_encode(array('message'=>'Profile created')));    
        }
        else {
            $this->response(500, json_encode(array('message'=>'Profile not created')));  
        }
        
        exit();
    }
    
    
    
    
    private function savePhoto($src, $path, $extension) {
        $allowed = array('png', 'jpg', 'gif','jpeg');
    
        if (!in_array(strtolower($extension), $allowed)) {
            return false;
        }
       
        $result = JFile::upload($src, $path);
        
        if ($result) {
            return true;
        }
        else {
            return false;
        }
    }
    
    
    
    
    public function update() {
        $user =& JFactory::getUser();
	    $fullname = JRequest::getVar('fullname', '', 'post', 'string');
	    $email = JRequest::getVar('email', '', 'post', 'string');
        $id = JRequest::getVar('id', '', 'post', 'int');
        
        
        if ($email != $user->email || $fullname != $user->name) {
            if ($email != $user->email) {
               $user->set('email', $email);
            }
            
            if ($fullname != $user->name) {
               $user->set('name', $fullname);
            }
        
            if (!$user->save()) {
                $this->response(500, json_encode(array('message'=>'Changes not saved')));
            }
            else {
                $this->response(200, json_encode(array('message'=>'Changes saved')));
            }
        }
        else {
            $this->response(500, json_encode(array('message'=>'No changes were made')));
        }
        
        exit();
    }
    
    
    
    
    public function updateuser() {
        JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
        
        $member =& $this->getModel('user');
        $application =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $user =& JFactory::getUser();
	    $fullname = JRequest::getVar('fullname', '', 'post', 'string');
	    $email = JRequest::getVar('email', '', 'post', 'string');
        $church = JRequest::getVar('church', '', 'post', 'string');
		$originalPassword = JRequest::getVar('currentpassword', '', 'post', 'string');
        $newPassword = JRequest::getVar('newpassword', '', 'post', 'string');
        $id = JRequest::getVar('id', '', 'post', 'int');
        $memberid = JRequest::getVar('memberid', '', 'post', 'int');
        
        if ($id != $user->get('id')) {
            $application->redirect($refer, 'Unauthorised user', 'error');
            
            return;
        }

        if ($originalPassword && $newPassword) {
            if (!$this->changePassword($originalPassword, $newPassword)){
                $application->redirect($refer, 'Failed to verify password', 'error');
                return;
            }
        }

        if(!$member->update($memberid, array('church'=>$church))) {
            $application->redirect($refer, 'Church could not be updated', 'error');
            return;
        }        
        
        if ($email != $user->email || $fullname != $user->name) {
            if ($email != $user->email) {
               $user->set('email', $email);
            }
            
            if ($fullname != $user->name) {
               $user->set('name', $fullname);
            }
        
            if (!$user->save()) {
                $application->redirect($refer, 'Changes not saved', 'error');
            }
        }
        
        $application->redirect($refer, 'Your details have been updated!', 'success');
    }
    
    
    public function logout() {
        $application =& JFactory::getApplication();
        $user =& JFactory::getUser();
        
        $application->logout($user->id);
        $application->redirect(JURI::base());    
    }
    
    
    
    private function changePassword($originalPassword, $newPassword) {
        $user =& JFactory::getUser();
        
        $password = $user->get('password');
        $salt = $this->getSalt($password);
        $currentpassword = $this->makeCrypt($originalPassword, $salt);
        
        if ($currentpassword != $password) {
            return false;
        }
        
        $newpassword = $this->makeCrypt($newPassword);
        
        $user->set('password', $newpassword);
        
        if (!$user->save()) {
            return false;
        }
        else {
            return true;
        }
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
    
    
    
    private function resizeImages($imageUrl, $destinationFolder, $extension, $id) {
        $thumbnail = new resize($imageUrl);
        $icon = new resize($imageUrl);
    
        $thumbnail->resizeImage(150, 150, 'crop');
        $thumbnail->saveImage($destinationFolder . 'user-' . $id . '-thumb.' . $extension);
    
    
        $icon->resizeImage(50, 50, 'crop');
        $icon->saveImage($destinationFolder . 'user-' . $id . '-icon.' . $extension);
    
        return true;    
    }
    
    
    
    private function resizeImage($imageUrl, $destinationFolder, $extension, $id) {
    
        // Instantiate our JImage object
        $image = new JImage($imageUrl);
        
        // Get the file's properties
        $properties = JImage::getImageFileProperties($imageUrl);
        
        // Resize the file as a new object
        $thumbnail = $image->resize(150, 150, true);
        $icon = $image->resize(50, 50, true);
        
        // Determine the MIME of the original file to get the proper type for output
        $mime = $properties->mime;
        
        switch ($mime) {
            case 'image/jpeg':
                $type = IMAGETYPE_JPEG;
            break;
            
            case 'image/png':
                $type = IMAGETYPE_PNG;
            break;
          
            case 'image/gif':
                $type = IMAGETYPE_GIF;
            break;
            
            default:
                $type = IMAGETYPE_JPEG;    
        }
        
        // Store the resized image to a new file
        $thumbnail->toFile($destinationFolder . 'user-' . $id . '-thumb.' . $extension, $type);
        $icon->toFile($destinationFolder . 'user-' . $id . '-icon.' . $extension, $type);
    }
    
    
    private function eMail($receiverid, $sendername, $subject, $message) {
        $user =& JFactory::getUser($receiverid);
        
        $body = "Hi {$user->name}, \n\n";
        $body .= "{$message} \n\n\n";
        $body .= "Holiness Page";
        
        $result = JUtility::sendMail('info@holinesspage.com', 'Holiness Page', $user->email, $subject, $body);
        
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
