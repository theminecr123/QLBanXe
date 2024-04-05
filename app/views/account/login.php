<?php
include_once 'app/views/share/header.php' ?>

<?php
    if(isset($errors)){
        foreach($errors as $x){
            echo '<li>' .$x.'</li>';
        }
        echo '</ul>';
    }
?>

<form class="user" action="/QLBanXe/account/checkLogin" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input type="email" class="form-control form-control-user"  placeholder="Email" name="email">
    </div>
    <div class="form-group">
        <input type="password" maxlength="50" class="form-control form-control-user"  placeholder="Password" name="password">
    </div>

    <button href="index.html" class="btn btn-primary btn-user btn-block" name = "submit">Login</button>
</form>

<?php
include_once 'app/views/share/footer.php' ?>