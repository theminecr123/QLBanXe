<?php
include_once 'app/views/share/header.php' ?>

<?php
    if(isset($errors)){
        foreach($errors as $x){
            echo '<li>$x</li>';
        }
        echo '</ul>';
    }
?>

<form class="user" action="/QLBanXe/product/save" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input type="text" class="form-control form-control-user"  placeholder="Name" name="name">
    </div>
    <div class="form-group">
        <input type="text" class="form-control form-control-user" placeholder="Description" name="description">
    </div>
    <div class="form-group">
        <input type="text"  class="form-control form-control-user" placeholder="Price" name="price">
    </div>
    <div class="form-group">
        <input type="file" class="form-control form-control-user"  placeholder="" name="image">
    </div>
    <button href="index.html" class="btn btn-primary btn-user btn-block" name = "submit">Submit</button>
</form>

<?php
include_once 'app/views/share/footer.php' ?>