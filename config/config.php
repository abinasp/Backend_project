<?php
    define("TEST_API_URL", "http://localhost/");
    function GetallRoutes(){
        $allRoutes = array(
            'user'=>'UserService',
            'customer'=>'CustomerService'
        );
        return $allRoutes;
    }

    function UploadPhoto($type, $fileName, $fileTempName, $fileError, $fileSize)
        {
            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array(
                'jpg',
                'JPG',
                'jpeg',
                'JPEG',
                'png',
                'PNG',
                'gif',
                'GIF'
            );
            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 1000000) {
                        $fileNewName = uniqid('', true) . "." . $fileActualExt;
                        // For Test
                        $fileDestination = $_SERVER['DOCUMENT_ROOT'] . "Backend_project/images/$type/" . $fileNewName;
                        if (move_uploaded_file($fileTempName, $fileDestination)) {
                            // For Test
                            $fileUrl = str_replace($_SERVER['DOCUMENT_ROOT'], TEST_API_URL, $fileDestination);
                            return array(
                                'status' => TRUE,
                                "message" => "Image uploaded succesfully",
                                "data" => $fileUrl
                            );
                        } else {
                            return array(
                                'status' => FALSE,
                                "message" => "Error in upload"
                            );
                        }
                    } else {
                        return array(
                            'status' => FALSE,
                            "message" => "File is too big.You can upload maximum 10mb"
                        );
                    }
                } else {
                    return array(
                        'status' => FALSE,
                        "message" => "Error in uploading image!!"
                    );
                }
            } else {
                return array(
                    'status' => FALSE,
                    "message" => "Invalid image type!! Image type should be jpg,jpeg,png,gif file."
                );
            }
        }

?>
