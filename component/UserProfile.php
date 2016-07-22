<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="resource/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="component/UserProfile.css" rel="stylesheet">
</head>
<body>

    <?php
        include 'Nav.php';
        echo $user->username.$user->email.date("Y-m-d H:i:s", $user->lasttime) ;
        ?>
    <div class="circle"><?php echo strtoupper(substr($user->username,0,1)); ?></div>


    <h2>这是UserProfile页面</h2>
    <script type="text/javascript" src="resource/jquery.min.js"></script>
    <script type="text/javascript" src="resource/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>