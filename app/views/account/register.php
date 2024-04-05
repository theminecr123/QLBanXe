<?php
include_once 'app/views/share/header.php';

// Kiểm tra và hiển thị lỗi nếu có
if(isset($errors) && count($errors) > 0){
    echo '<ul class="error-list">';
    foreach($errors as $error){
        echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
}

// Giữ lại dữ liệu đã nhập nếu có
$nameValue = isset($_POST['name']) ? $_POST['name'] : '';
$emailValue = isset($_POST['email']) ? $_POST['email'] : '';

?>

<form class="user" action="/QLBanXe/account/save" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <input type="text" class="form-control form-control-user" placeholder="Fullname" name="name" value="<?php echo htmlspecialchars($nameValue); ?>">   
    </div> 
    <div class="form-group">
        <input type="email" class="form-control form-control-user" placeholder="Email" name="email" value="<?php echo htmlspecialchars($emailValue); ?>">
    </div>
    <div class="form-group">
        <input type="password" maxlength="50" class="form-control form-control-user" placeholder="Password" name="password">
    </div>
    <div class="form-group">
        <input type="password" maxlength="50" class="form-control form-control-user" placeholder="Confirm Password" name="confirmPassword">
    </div>
    <select name="role">
        <option value="admin">admin</option>
        <option value="mod">mod</option>
        <option value="user">user</option>
    </select>
    <button class="btn btn-primary btn-user btn-block" name="submit">Register</button>
</form>

<?php
include_once 'app/views/share/footer.php';
?>
