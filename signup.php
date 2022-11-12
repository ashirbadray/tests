<?php
    include("config.php");
    $response =[
        'status'=>0,
        'message'=>'Form Submission Failed',
    ];
    $uploadDir = "uploads/";
    $errorEmpty = false;
    $errorEmail = false;

    if (isset($_POST['firstname'])  || isset($_POST['lastname']) || isset($_POST['email']) || isset($_POST['password']) ||isset($_POST['files']))
    {
        //$response['message'] = "First Name";
        $firstname = $_POST['firstname'];
        $lastname  = $_POST['lastname'];
        $email     = $_POST['email'];
        $password  = $_POST['password'];
        //$files      = $_POST['files'];
        if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($_FILES['files']['name']))
        {
            if(!filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                $response['message'] = "Invalid EMail";
                $errorEmail = true;
            }
            if($errorEmpty == false && $errorEmail == false)
            {
                $uploadStatus =1;
                $uploadFile = '';
                if(!empty($_FILES['files']['name']))
                {
                    $fileName = basename($_FILES['files']['name']);
                    $targetFilepath = $uploadDir.$fileName;
                    $fileType = pathinfo($targetFilepath,PATHINFO_EXTENSION);
                    //Check FIle Already exits
                    if(file_exists($targetFilepath))
                    {
                        $response['message'] = "Files Already Exist";
                        $uploadStatus= 0;
                    }
                    else{
                        if($_FILES['files']['size'] >50000)
                        {
                            $response['message']= "Files SIze Too large";
                            $uploadStatus=0;
                        }
                        else{
                            if(move_uploaded_file($_FILES['files']['tmp_name'],$targetFilepath))
                            {
                                $uploadFile = $fileName;
                                $uploadStatus=1;
                            }
                            else{
                                $response['message'] = "Sorry An error Occured";
                                $uploadStatus=0;
                            }
                        }
                    }
                }
                if($uploadStatus==1)
                {
                    $hash = md5($password);
                    $check = "SELECT * FROM user where email='".$email."'";
                    $r = mysqli_query($con,$check);
                    if(mysqli_num_rows($r)==1)
                    {
                        $response['message']="The Email id Already exits";
                    }
                    else{
                    $query = "INSERT INTO user(`firstname`, `lastname`, `email`, `password`, `image`) VALUES ('$firstname','$lastname','$email','$hash','$uploadFile')";
                       
                        if(mysqli_query($con,$query))
                        {
                            $response['message']="Data Inserted Successfully";
                            $response['status'] =1; 
                        }
                    }
                }

            }
            
        }
 
    }
    echo json_encode($response);
?>