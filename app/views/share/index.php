<?php include_once 'app/views/share/header.php'; ?>
<div class="container-fluid">
    <!-- <a href="add" class="btn btn-success btn-icon-split"> -->
        <!-- <span class="icon text-white-50">
            <i class="fas fa-check"></i>
        </span> -->
        <!-- <span class="text">Thêm sản phẩm</span> -->
        <!-- <button href="add" class="btn-add-product"> Watch </button> -->
    <!-- </a> -->

    <a href="add" >
    <button style="margin-left:-3px;" class="btn-add-product"> Thêm Sản Phẩm </button>
    </a>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" >
                <thead>
    <tr>
        <th class='table-header-listproduct' id='listproduct-id'>ID</th>
        <th class='table-header-listproduct' id='listproduct-name'>NAME</th>
        <th class='table-header-listproduct' id='listproduct-id'>DESCRIPTION</th>
        <th class='table-header-listproduct' id='listproduct-price'>PRICE</th>
        <th class='table-header-listproduct' id='listproduct-image'>IMAGE</th>
        <th class='table-header-listproduct' id='listproduct-id'>Action</th>
        <th class='table-header-listproduct' id='listproduct-id'>Add to Cart</th> <!-- Thêm cột mới -->
    </tr>
</thead>
<tbody>
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td class='table-header-listproduct-item'><?= $row['id']; ?>
        </td>
            <td class='table-header-listproduct-item'><?= $row['name']; ?></td>
            <td class='table-header-listproduct-item'><?= $row['description']; ?></td>
            <td class='table-header-listproduct-item'><?= number_format($row['price'],'0','.'); ?></td>
            <td style="max-width:120px;">
            <?php
                            if (empty($row['image']) || !file_exists($row['image'])) {
                                echo "No Image!";
                            } else {
                                echo "<img src='/QLBanXe/" . $row['image'] . "' alt='' style='width:120px; height:120px; border-radius:20px; margin-left:5px;' />";
                            }
                            ?>
            </td>
            <td style="max-width:80px;">
                <button class="button-edit-listproduct" onclick="window.location.href='edit?id=<?= $row['id']; ?>'">Sửa</button></br>
                <button class="deleteButton" data-id="<?= $row['id']; ?>">Xoá</button>
            </td>
            <td style="max-width:120px;"><button style="width:180px; margin-top: 30px; margin-left:8px;" id="button-add-cart" class="addToCartButton btn btn-danger" data-id="<?= $row['id']; ?>">Thêm vào giỏ hàng</button></td> <!-- Nút thêm vào giỏ hàng -->
            <!-- <td>
            </td> -->
        </tr>
    <?php endwhile; ?>
</tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once 'app/views/share/footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
    
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": true, // Enable pagination
            "pageLength": 5, // Number of rows per page
        });
    });
</script>

<script>


$(document).ready(function() {
    // Xử lý sự kiện click vào nút "Thêm vào giỏ hàng"
    $('.addToCartButton').click(function() {
        var productId = $(this).data('id');
        
        // Gửi yêu cầu AJAX để thêm sản phẩm vào giỏ hàng
        $.ajax({
            url: '/QLBanXe/cart/Add/' + productId,
            type: 'POST',
            success: function(response) {
                // Sau khi thêm sản phẩm vào giỏ hàng thành công, có thể thực hiện các hành động tiếp theo nếu cần
                alert('Đã thêm sản phẩm có ID ' + productId + ' vào giỏ hàng.');
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi nếu có
                alert('Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng: ' + error);
            }
        });
    });
});

$(document).ready(function() {
    $('.deleteButton').click(function() {
        var productId = $(this).data('id');
        
        $.ajax({
            url: '/QLBanXe/product/delete/' + productId,
            type: 'POST',
            success: function(response) {
                // Xử lý phản hồi từ máy chủ nếu cần
                alert('Đã xoá sản phẩm có ID ' + productId);
                // Reload trang hoặc làm mới danh sách sản phẩm
                location.reload();
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi nếu có
                alert('Đã xảy ra lỗi khi xoá sản phẩm: ' + error);
            }
        });
    });
});
</script>
