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
            $fetchUser = $db->OnFetchData('users', $user);
            if(!$fetchUser['status']){
                throw new Exception("User doesn't exist or wrong password");
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

    function OnCreateUser(){
        try{
            $db = new Database();
            $postData = json_decode(@file_get_contents('php://input'),TRUE);
            $user = $postData['user'];
            $auth = $postData['auth'];
            if(!isset($auth)){
                throw new Exception('Authentication is required.');
            }
            if(!$auth){
                throw new Exception('Please Login.');
            }
            if(!isset($user)){
                throw new Exception('Employee is required for creating.');
            }
            $userData = array('username'=>$user['username']);
            $fetchUser = $db->OnFetchSingle('users', $userData);
            if($fetchUser['status']){
                throw new Exception('Username is already exist.');
            }
            $insertUser = $db->OnInsertData('users',$user);
            if(!$insertUser['status']){
                throw new Exception('Error in inserting data');
            }
            return json_encode(array('sucess'=>TRUE, 'message'=>'Employee has been created successfully'));
        }catch(Exception $ex){
            return json_encode(array(
                'success'=>FALSE,
                'message' => 'Error in creating employee',
                'error' => $ex->getMessage()
            ));
        }
    }

    function OnFetchEmployees(){
        try{
            $db = new Database();
            $postData = json_decode(@file_get_contents('php://input'),TRUE);
            $auth = $postData['auth'];
            if(!isset($auth)){
                throw new Exception('Authentication is required.');
            }
            if(!$auth){
                throw new Exception('Please Login.');
            }
            $fetchEmployees = $db->OnFetchAllData('users');
            if(!$fetchEmployees['status']){
                throw new Exception('No epmployee found!!');
            }
            return json_encode(array('success'=>TRUE, 'message'=>'Fetched employee list', 'error'=>$ex->getMessage()));
        }catch(Exception $ex){
            return json_encode(array(
                'success'=>FALSE,
                'message'=>'Error in fetching employee lists',
                'error'=>$ex->getMessage()
            ));
        }
    }


}
?>