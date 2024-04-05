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

<form class="user" action="/QLBanXe/product/edit" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $product->id; ?>">
    <div class="form-group">
        <input type="text" class="form-control form-control-user" name="name" value="<?php echo $product->name; ?>" placeholder="Product Name">
    </div>
    <div class="form-group">
        <input type="text" class="form-control form-control-user" name="description" value="<?php echo $product->description; ?>" placeholder="Product Description">
    </div>
    <div class="form-group">
        <input type="text" class="form-control form-control-user" name="price" value="<?php echo $product->price; ?>" placeholder="Product Price">
    </div>
    <div class="form-group">
        <input type="file" class="form-control form-control-user" name="image" value="<?php echo $product->image; ?>">
    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block" name="submit">Submit</button>
</form>




<?php
include_once 'app/views/share/footer.php' ?>