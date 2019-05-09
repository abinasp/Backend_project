<?php

require_once 'config/Database.php';
require_once 'config/config.php';

class UserService
{

    /**
     *
     * @function
     * @memberof services:UserService
     * @name OnRun
     * @description Used to execute the particular method according to method name and using Switch case in UserService.
     * @parameter $method=>list of api name.
     */
    function OnRun($method)
    {
        switch ($method) {
            case 'signup':
                echo $this->OnSignUpUser();
                break;
            case 'login':
                echo $this->OnLoginUser();
                break;
            default:
                echo json_encode(array(
                    'success' => FALSE,
                    'message' => 'API is invalid.'
                ));
        }
    }

    /**
     *
     * @function
     * @memberof services:UserService
     * @name OnSignUpUser
     * @description Used to signup user.
     * @returnVal Signup message
     */
    
    function OnSignUpUser()
    {
        try {
            $db = new Database();
            $postData = json_decode(@file_get_contents('php://input'),TRUE);
            $newUser = $postData['newUser'];
            if(!isset($newUser)){
                throw new Exception('New user details is required for signup.');
            }
            $insertUser = $db->OnInsertData('users', $newUser);
            if(!$insertUser['status']){
                throw new Exception('Error in signup');
            }
            return json_encode(array('success'=>TRUE,'message'=>'User signup successful.'));
        } catch (Exception $ex) {
            return json_encode(array(
                'success' => FALSE,
                'message' => 'Error in signup',
                'error' => $ex->getMessage()
            ));
        }
    }

    /**
     *
     * @function
     * @memberof services:UserService
     * @name OnLoginUser
     * @description Used to login user.
     * @returnVal login message.
     */
    
    function OnLoginUser()
    {
        try {
            $db = new Database();
            $postData = json_decode(@file_get_contents('php://input'),TRUE);
            $user = $postData['user'];
            if(!isset($user)){
                throw new Exception('User is required for log in.');
            }
            $fetchUser = $db->OnFetchSingle('users', $user);
            if(!$fetchUser['status']){
                throw new Exception("User doesn't exist");
            }
            return json_encode(array('success'=>TRUE,'message'=>'Login successful'));
        } catch (Exception $ex) {
            return json_encode(array(
                'success' => FALSE,
                'message' => 'Error in login',
                'error' => $ex->getMessage()
            ));
        }
    }
}
?>