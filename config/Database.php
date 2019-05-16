<?php

class Database{
    var $connection;
    
    var $db_host = 'localhost';
    var $db_username = 'abinas';
    var $db_password = 'root';
    var $db_name = 'somobay_somiti';
    
    /**
     *
     * @function
     * @memberof config:Database
     * @name constructor
     * @description Database connection and store it in connection variable.
     */
    
    public function __construct()
    {
        $this->connection = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name);
        if (! $this->connection) {
            die("Couldn't connect to the database");
        } else {
            return $this->connection;
        }
    }
    
    /**
     *
     * @function
     * @memberof config:Database
     * @name OnBeginTransaction
     * @description Used to begin transaction.
     */
    function OnBeginTransaction()
    {
        $this->connection->begin_transaction();
        return TRUE;
    }
    
    /**
     *
     * @function
     * @memberof config:Database
     * @name OnCommitTransaction
     * @description Used to commit transaction.
     */
    function OnCommitTransaction()
    {
        $this->connection->commit();
        return TRUE;
    }
    
    /**
     *
     * @function
     * @memberof config:Database
     * @name OnRollbackTransaction
     * @description Used to rollback a transaction.
     */
    function OnRollbackTransaction()
    {
        $this->connection->rollback();
        return TRUE;
    }
    
    /**
     *
     * @function
     * @memberof config:Database
     * @name OnInsertData
     * @description insert data into the database.
     * @parameter tableName and data
     * @returnVal Insert data message with insertedId
     */
    
    function OnInsertData($tableName,$data){
        $fieldName = [];
        $fieldValue = [];
        foreach ($data as $key => $value) {
            array_push($fieldName, $key);
            array_push($fieldValue, $value);
        }
        $field_names = implode(',', $fieldName);
        $field_values = implode("','", $fieldValue);
        $sql = "INSERT INTO $tableName (" . $field_names . ") VALUES ('" . $field_values . "') ";
        $this->OnBeginTransaction();
        if (mysqli_query($this->connection, $sql)) {
            $this->OnCommitTransaction();
            return array(
                'status' => TRUE,
                'message' => 'New record created successfully',
                'data' => mysqli_insert_id($this->connection)
            );
        } else {
            $this->OnRollbackTransaction();
            return array(
                'status' => FALSE,
                'message' => 'Error in inserting data!!'
            );
        }
    } 
    
    /**
     *
     * @function
     * @memberof config:Database
     * @name OnUpdateData
     * @description update data into the database.
     * @parameters tablename, data, update reference, update reference value.
     * @returnVal update data message.
     */
    
    function OnUpdateData($tableName, $data, $updateRef, $updateRefVal) {
        $setFields = array();
        foreach ($data as $key => $value) {
            $setFields[] = "$key = '$value'";
        }
        $sql = "UPDATE $tableName SET " . implode(', ', $setFields) . " WHERE $updateRef='$updateRefVal'";
        $this->OnBeginTransaction();
        if (mysqli_query($this->connection, $sql)) {
            $this->OnCommitTransaction();
            return array(
                'status' => TRUE,
                'message' => 'Data modified succesully!!'
            );
        } else {
            $this->OnRollbackTransaction();
            return array(
                'status' => FALSE,
                'message' => 'Error in updating fields.'
            );
        }
    }
    
    /**
     *
     * @function
     * @memberof config:Database
     * @name OnFetchData
     * @description fetch all data from a table from the database.
     * @parameters tablename, data,
     * @returnVal fetch all records.
     */
    
    function OnFetchData($tableName, $data)
    {
        $setFields = array();
        foreach ($data as $key => $value) {
            $setFields[] = "$key = '$value'";
        }
        $sql = "SELECT * FROM $tableName WHERE " . implode(' AND ', $setFields);
        $isExists = mysqli_query($this->connection, $sql);
        $fetchedData = array();
        if (mysqli_num_rows($isExists) > 0) {
            while ($row = mysqli_fetch_assoc($isExists)) {
                array_push($fetchedData, $row);
            }
            return array(
                'status' => TRUE,
                'message' => "Data exists!!",
                'data' => $fetchedData
            );
        } else {
            return array(
                'status' => FALSE,
                'message' => "No data exists!!",
                'data' => array()
            );
        }
    }
    
    /**
     *
     * @function
     * @memberof config:Database
     * @name OnFetchAllData
     * @description Used to fetch all data of a table.
     * @parameter $tableName.
     * @returnVal all rows
     */
    function OnFetchAllData($tableName)
    {
        $sql = "SELECT * FROM $tableName ORDER BY id DESC";
        $isExists = mysqli_query($this->connection, $sql);
        $fetchedData = array();
        if (mysqli_num_rows($isExists) > 0) {
            while ($row = mysqli_fetch_assoc($isExists)) {
                array_push($fetchedData, $row);
            }
            return array(
                'status' => TRUE,
                'message' => 'Data exists!!',
                'data' => $fetchedData
            );
        } else {
            return array(
                'status' => FALSE,
                'message' => 'No data exists!!',
                'data' => array()
            );
        }
    }
    
    /**
     *
     * @function
     * @memberof config:DBConfig
     * @name OnFetchSingle
     * @description Used to fetch single data on basis of unique key.
     * @parameter $tableName,$data.
     * @returnVal fetchedData.
     */
    
    function OnFetchSingle($tableName,$data) {
        $keys = array_keys($data);
        $fieldName = $keys[0];
        $fieldValue = $data[$fieldName];
        $sql = "SELECT * FROM $tableName WHERE $fieldName='$fieldValue'";
        $isExist = mysqli_query($this->connection, $sql);
        if (mysqli_num_rows($isExist) > 0) {
            return array(
                'status' => TRUE,
                'message' => 'Data exist!!',
                'data' => mysqli_fetch_assoc($isExist)
            );
        } else {
            return array(
                'status' => FALSE,
                'message' => "Data doesn't exist!!"
            );
        }
    }
    
    /**
     *
     * @function
     * @memberof config:Database
     * @name OnDeleteSingle
     * @description Used to delete a row from the table
     * @parameter $tableName,$data, $deleteRef,$deletRefVal.
     * @returnVal multiple update message.
     */
    
    function OnDeleteData($tableName, $deleteRef, $deleteRefVal)
    {
        $sql = "DELETE FROM $tableName WHERE $deleteRef='$deleteRefVal'";
        if (mysqli_query($this->connection, $sql)) {
            return array(
                'status' => TRUE,
                'message' => 'Data deleted succesfully!!'
            );
        } else {
            return array(
                'status' => FALSE,
                'message' => 'Error in deleting data!!'
            );
        }
    }    
}
?>