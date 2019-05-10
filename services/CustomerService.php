<?php

require_once 'config/config.php';
require_once 'config/Database.php';

class CustomerService {
    
    function OnRun($method) {
        switch($method){
            case 'register-customer':
            case 'update-customer':
            case 'get-customers':
            case 'delete-customers':
        }
    }
    
    /**
     *
     * @function
     * @memberof services:CustomerService
     * @name OnCreateCustomer
     * @description Used to create customer.
     * @returnVal create customer message.
     */
    
    function OnCreateCustomer(){
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
            $customer = $postData['customer'];
            if(!isset($customer)){
                throw new Exception('Customer details is required.');
            }
            $insertCustomer = $db->OnInsertData('customers', $customer);
            if(!$insertCustomer['status']){
                throw new Exception('Error in saving customer.');
            }
            return json_encode(array('success'=>TRUE,'message'=>'Customer has been created successfully'));
        }catch(Exception $ex){
            return json_encode(array('success'=>FALSE,'message'=>'Error in creating customers','error'=>$ex->getMessage()));
        }
    }    
    
    /**
     *
     * @function
     * @memberof services:CustomerService
     * @name OnUpdateCustomer
     * @description Used to update customer.
     * @returnVal update customer message.
     */
    
    function OnUpdateCustomer(){
        try{
            $db = new Database();
            $postData = json_decode(@file_get_contents('php://input'),TRUE);
            $auth = $postData['auth'];
            if(!isset($auth)){
                throw new Exception('Authentication is required.');
            }
            if(!$auth){
                throw new Exception('Please login.');
            }
            $customer = $postData['customer'];
            if(!isset($customer)){
                throw new Exception('Customer is required.');
            }
            $updateCustomer = $db->OnUpdateData('customers', $customer, 'id', $customer['id']);
            if(!$updateCustomer['status']){
                throw new Exception('Error in updating customer.');
            }
            return json_encode(array('success'=>TRUE, 'message'=>'Custome updated succesfully'));
        }catch(Exception $ex){
            return json_encode(array('success'=>FALSE, 'message'=>'Error in updating customers.','error'=>$ex->getMessage()));
        }
    }
    
    /**
     *
     * @function
     * @memberof services:CustomerService
     * @name OnGetCustomers
     * @description Used to get all customers.
     * @returnVal get all customers
     */
    
    function OnGetCustomers(){
        try{
            $db = new Database();
            $postData = json_decode(@file_get_contents('php://input'),TRUE);
            $auth = $postData['auth'];
            if(!isset($auth)){
                throw new Exception('Authentication is required.');
            }
            if(!$auth){
                throw new Exception('Please login.');
            }
            $fetchCustomers = $db->OnFetchAllData('customers');
            if(!$fetchCustomers['status']){
                throw new Exception('Error in fetching all customers.');
            }
            return json_encode(array('success'=>TRUE, 'message'=>'List of customers are found.', 'data'=>$fetchCustomers['data']));
        }catch(Exception $ex){
            return json_encode(array('success'=>FALSE, 'message'=>'Error in getting all customers','error'=>$ex->getMessage()));
        }
    }
    
    /**
     *
     * @function
     * @memberof services:CustomerService
     * @name OnDeleteCustomer
     * @description Used to delete customer.
     * @returnVal deleted message.
     */
    
    function OnDeleteCustomer(){
        try{
            $db = new Database();
            $postData = json_decode(@file_get_contents('php://input'),TRUE);
            $auth = $postData['auth'];
            if(!isset($auth)){
                throw new Exception('Authentication is required.');
            }
            if(!$auth){
                throw new Exception('Authentication failed, Please login.');
            }
            $customer = $postData['customer'];
            if(!isset($customer)){
                throw new Exception('Customer is required for deletion.');
            }
            $onDeleteCustomer = $db->OnDeleteData('customers', 'id', $customer['id']);
            if($onDeleteCustomer['status']){
                throw new Exception('Error in delet the customer');
            }
            return json_encode(array('success'=>TRUE, 'message'=>'Custome has been deleted succesfully'));
        }catch(Exception $ex){
            return json_encode(array('success'=>FALSE, 'message'=>'Error in deleteing customer','error'=>$ex->getMessage()));
        }
    }
}
?>