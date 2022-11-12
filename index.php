<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .row {
            display: flex;
            margin: 10px;
        }
        .form-message
        {
            display: none;
            background: skyblue;
            padding:10px;
            color:black;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="form">
        <h1>Create An Account</h1>
        <form autocomplete="off" id="myForm">

            <div class="form-message"></div>
            <div class="row">
                <div class="field column">
                    <label>First Name</label>
                    <input type="text" name="firstname">
                </div>
                <div class="field column">
                    <label>Last Name</label>
                    <input type="text" name="lastname">
                </div>
            </div>
            <div class="row">
                <div class="field column">
                    <label>Email</label>
                    <input type="text" name="email">
                </div>

            </div>
            <div class="row">

                <div class="field column">
                    <label>Password</label>
                    <input type="password" name="password">
                </div>
                <div class="field column">
                    <label>Uplaod Picture</label>
                    <input type="file" name="files" id="files">
                </div>
            </div>
            <div class="row">
                <div class="field column">

                    <input type="submit" name="submit" value="signup">
                </div>

            </div>
    </form>     

    </div>
    <script type="text/javascript">
        $(document).ready(function() {
           $("#myForm").on('submit',function(e){
                 e.preventDefault();
                 //alert('clicked Me');
                 $.ajax({
                    type:"POST",
                    url: "signup.php",
                    data: new FormData(this),
                    dataType: "json",
                    contentType:false,
                    cache:false,
                    processData:false,
                    success: function(response)
                    {
                        $(".form-message").css("display","block");
                        if(response.status==1)
                        {
                            $("#myForm").reset();
                            $(".form-message").html('<p>'+ response.message+'</p>');
                        }
                        else{
                            $('.form-message').html('<p>'+response.message+'</p>');
                        }
                    }
                 });
           });
/*-- File Validation--*/
              $("#files").change(function()
              {
                  var file = this.files[0];
                  var filetype = file.type;
                  var match = ['image/jpg','image/jpeg','iamge/.png'];
                  if(!((filetype==match[0])||(filetype==match[1]||(filetype==match[2]))))
                  {
                    alert('sorry this file format is not allowed');
                    $("#files").val('');
                    return false;
                  }
              });
   

        });


    </script>
</body>

</html>