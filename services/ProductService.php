<?php

require_once 'config/Database.php';
require_once 'config/config.php';

class ProductService
{

    /**
     *
     * @function
     * @memberof services:ProductService
     * @name OnRun
     * @description Used to execute the particular method according to method name and using Switch case in UserService.
     * @parameter $method=>list of api name.
     */
    function OnRun($method)
    {
        switch ($method) {
            case 'create-product':
                echo $this->OnCreateProduct();
                break;
            case 'update-product':
                echo $this->OnUpdateProduct();
                break;
            case 'delete-product':
                echo $this->OnDeleteProduct();
                break;
            case 'get-products':
                echo $this->OnGetAllProducts();
                break;
            default:
                echo json_encode(array(
                    'success' => FALSE,
                    'message' => 'API is invalid'
                ));
        }
    }

    /**
     *
     * @function
     * @memberof services:ProductService
     * @name OnCreateProduct
     * @description Used to create a new product and save it into the database.
     * @returnVal successful message of creating product.
     */
    function OnCreateProduct()
    {
        try {
            $db = new Database();
            $postData = json_decode(@file_get_contents('php://input'),TRUE);
            $newProduct = $postData['newProduct'];
            if(!isset($newProduct)){
                throw new Exception('Product is required.');
            }
            $insertProduct = $db->OnInsertData('products', $newProduct);
            if(!$insertProduct['status']){
                throw new Exception('Error in inserting the product.');
            }
            return json_encode(array('success'=>TRUE,'message'=>'New product added successfully.'));
        } catch (Exception $ex) {
            return json_encode(array(
                'success' => FALSE,
                'message' => 'Error in creating the product.',
                'error' => $ex->getMessage()
            ));
        }
    }

    /**
     *
     * @function
     * @memberof services:ProductService
     * @name OnUpdateProduct
     * @description Used to update product and save it into the database.
     * @returnVal successful message of updating product.
     */
    function OnUpdateProduct()
    {
        try {
            $db = new Database();
            $postData = json_decode(@file_get_contents('php://input'),TRUE);
            $product = $postData['product'];
            if(!isset($product)){
                throw new Exception('Product is required.');
            }
            $updateProduct = $db->OnUpdateData('products', $product, 'id', $product['id']);
            if(!$updateProduct['status']){
                throw new Exception('Error in updating.');
            }
            return json_encode(array('success'=>TRUE,'message'=>'Product has been updated successfully.'));
        } catch (Exception $ex) {
            return json_encode(array(
                'success' => FALSE,
                'message' => 'Error in updating the product.',
                'error' => $ex->getMessage()
            ));
        }
    }

    /**
     *
     * @function
     * @memberof services:ProductService
     * @name OnDeleteProduct
     * @description Used to delete product from the database.
     * @returnVal successful message of deleting product.
     */
    function OnDeleteProduct()
    {
        try {} catch (Exception $ex) {
            return json_encode(array(
                'success' => FALSE,
                'message' => 'Error in deleting the product.',
                'error' => $ex->getMessage()
            ));
        }
    }

    /**
     *
     * @function
     * @memberof services:ProductService
     * @name OnGetAllProducts
     * @description Used to get all products from the database.
     * @returnVal successful message of all product.
     */
    function OnGetAllProducts()
    {
        try {} catch (Exception $ex) {
            return json_encode(array(
                'success' => FALSE,
                'message' => 'Error in getting all the products.',
                'error' => $ex->getMessage()
            ));
        }
    }
}
?>