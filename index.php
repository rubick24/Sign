<?php
/**
 * Created by PhpStorm.
 * User: Deada
 * Date: 2016/7/17
 * Time: 14:20
 */
require_once './Database.php';
require_once './User.php';
require_once './ProjectForm.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="resource/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="resource/main.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-default" style="margin-bottom: 0" >
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Logo</a>
            </div>
            <div class="navbar-collapse">
                <ul class="nav navbar-nav navbar-right" id="userStatus">
                <?php
                if(isset($_SESSION['uid'])&&!empty($_SESSION['uid'])){
                    $user = new User();
                    $user = $user->getUserInfo($_SESSION['uid']);
                    echo "<p class=\"navbar-text\">Signed in as</p><li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">".$user->username."<span class=\"caret\"></span></a><ul class=\"dropdown-menu\"><li><a href=\"#\">Action</a></li><li role=\"separator\" class=\"divider\"></li><li><a href=\"#\" id=\"signOut\">Sign out</a></li></ul></li>";
                }
                else echo "<button type=\"button\" class=\"btn btn-primary navbar-btn\" data-toggle=\"modal\" data-target=\"#signModal\">Sign in</button>"
                ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="modal fade" id="signModal" tabindex="-1" role="dialog" aria-labelledby="signModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="signModalLabel">Sign In</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="userInput">Username or email address</label>
                        <input type="text" class="form-control" id="userInput" >
                    </div>
                    <div class="form-group" >
                        <label for="Password">Password</label>
                        <a class="pull-right" style="font-size: 12px" href="#" content="Password">Forgot password?</a>
                        <input type="password" class="form-control" id="Password" >
                    </div>
                    <div class="form-group">
                        <a href="#"></a>
                    </div>
                    <div class="form-group" id="errorBox"></div>
                    <button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>
                    <button id="signBtn" class="btn btn-primary pull-right">Sign in</button>
                </div>
            </div>
        </div>
    </div>

    <div class="jumbotron" id="MainJum" style="height: 400px;" >
        <div class="container" >
            <h1>Title</h1>
            <p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
            <!--<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>-->
        </div>
    </div>
    <?php

    ?>


    <script type="text/javascript" src="resource/jquery.min.js"></script>
    <script type="text/javascript" src="resource/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $("#signBtn").click(function() {
            var data="code=1&userinput="+$('#userInput').val()+"&password="+$('#Password').val();
            $.post(
                "Controller.php",
                data,
                function (result) {
                    result=strToJson(result);
                    if (result.status){
                        $('#signModal').modal('hide');
                        var userStatus=$("#userStatus");
                        userStatus.empty();
                        userStatus.append("<p class=\"navbar-text\">Signed in as</p><li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">"+result.username+"<span class=\"caret\"></span></a><ul class=\"dropdown-menu\"><li><a href=\"#\">Your Profile</a></li><li role=\"separator\" class=\"divider\"></li><li><a href=\"#\" id=\"signOut\">Sign out</a></li></ul></li>")
                        window.location.reload();
                    }
                    else {
                        var errorBox=$('#errorBox');
                        errorBox.empty();
                        errorBox.append("<div class=\"alert alert-danger\" role=\"alert\">Sign in failed</div>");
                    }
                }
            )
        });

        $("#signOut").click(function () {
            $.post(
                "Controller.php",
                "code=2&SignOut=true",
                function () {
                    window.location.reload();
                }
            );
        });

        function strToJson(str){
            return JSON.parse(str);
        }
    </script>
</body>
</html>