<?php
include_once 'app/views/share/header.php';

// Tính tổng giá trị của giỏ hàng
$totalCartValue = 0;

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Giỏ hàng trống!";
} else {
    echo "<h2>Danh sách giỏ hàng</h2>";
    echo "<table id='cartTable' class='display'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Name</th>";
    echo "<th>Price</th>";
    echo "<th>Image</th>";
    echo "<th>Quantity</th>";
    echo "<th>Total</th>"; // Thêm cột mới để hiển thị tổng tiền của từng sản phẩm
    echo "<th>Action</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($_SESSION['cart'] as $item) {
        echo "<tr>";
        echo "<td class='table-header-item'>$item->id</td>";
        echo "<td class='table-header-item'>$item->name</td>";
        echo "<td class='table-header-item'>$item->price</td>";
        echo "<td class='table-header-item'><img src='/QLBanXe/$item->image' alt='Product Image' style='width:120px; height:120px; border-radius:10px;'></td>";
        echo "<td>
                <input name='id' type='hidden' value='$item->id' /> 
                <input name='quantity' type='number' value='$item->quantity' class='quantityInput' data-id='$item->id'/> <!-- Thêm data-id để xác định sản phẩm -->
            </td>";
        echo "<td class='itemTotal'></td>"; 
        echo "<td>
                <button class='btn btn-danger deleteButton' data-id='$item->id'>Delete</button>
            </td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    // Thêm một định dạng mới với id 'totalCartValueContainer'
    echo "<p id='totalCartValueContainer'>Total Cart Value: <span id='totalCartValue'></span><span> VND</span></p>";
    if (isset($_POST['checkout_form'])) {
        echo "<h3>Thông tin giao hàng</h3>";
        echo "<form action='/QLBanXe/order/showCheckoutForm' method='post'>";
        echo "<div class='form-group'>";
        echo "<label for='name'>Họ và tên: (bắt buộc)</label>";
        echo "<input type='text' name='name' id='name' class='form-control' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='address'>Địa chỉ: (bắt buộc)</label>";
        echo "<input type='text' name='address' id='address' class='form-control' required>";
        echo "</div>";
        echo "<div class='form-group'>";
        echo "<label for='phone'>Số điện thoại: (bắt buộc)</label>";
        echo "<input type='text' name='phone' id='phone' class='form-control' required>";
        echo "</div>";
        echo "<input type='submit' value='Đặt hàng' class='btn btn-primary'>";
        echo "</form>";
    } else {
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='checkout_form' value='1'>";  
        echo "<input type='submit' value='Thanh toán'>";
        echo "</form>";
    }
}
include_once 'app/views/share/footer.php';
?>

<script>
// Function to calculate and update the total price of each product
function updateItemTotal() {
    document.querySelectorAll('.display tbody tr').forEach(row => {
        let price = parseFloat(row.querySelector('td:nth-child(3)').textContent);
        let quantity = parseInt(row.querySelector('.quantityInput').value);
        let total = price * quantity;
        
        // Format total as currency in VND with thousand separators
        let formattedTotal = total.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
        
        row.querySelector('.itemTotal').textContent = formattedTotal;
    });
}

function updateTotalCartValue() {
    let total = 0;
    document.querySelectorAll('.display tbody tr').forEach(row => {
        // Calculate each item's total, parse as float, and add to the total cart value
        let totalItemText = row.querySelector('.itemTotal').textContent;
        let totalItem = parseFloat(totalItemText.replace(/[^0-9.-]+/g, ''));
        total += totalItem;
    });
    
    // Format the total cart value as currency in VND with thousand separators
    const formattedTotalCartValue = total.toLocaleString('vi-VN', {
        currency: 'VND',
    });

    // Update the total cart value on the web page
    document.getElementById('totalCartValue').textContent = formattedTotalCartValue;
}


function updateCartItem(id, quantity) {
    id = parseInt(id);
    quantity = parseInt(quantity);

    let formData = new FormData();
    formData.append('id', id);
    formData.append('quantity', quantity);

    fetch('/QLBanXe/cart/updateQuantity/', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Cập nhật số lượng sản phẩm không thành công');
        }
        return response.json();
    })
    .then(data => {
        // Sau khi cập nhật số lượng sản phẩm, cập nhật tổng giá trị giỏ hàng và tổng tiền của mỗi sản phẩm
        updateItemTotal();
        updateTotalCartValue();
    })
    .catch(error => {
        console.error('Lỗi: ', error);
    });
}

// Function để gửi yêu cầu xoá sản phẩm khỏi giỏ hàng
function deleteCartItem(id) {
    fetch('/QLBanXe/cart/deleteItem/' + id, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            // Sau khi xoá sản phẩm, reload trang để cập nhật lại giỏ hàng và tổng giá trị giỏ hàng
            location.reload();
        } else {
            console.error('Xoá sản phẩm không thành công');
        }
    })
    .catch(error => {
        console.error('Lỗi: ', error);
    });
}

// Event listener cho input số lượng sản phẩm
document.querySelectorAll('.quantityInput').forEach(input => {
    input.addEventListener('change', (event) => {
        let id = input.getAttribute('data-id');
        let quantity = input.value;
        updateCartItem(id, quantity); // Gọi function để cập nhật số lượng sản phẩm
    });
});

// Event listener cho nút xoá sản phẩm
document.querySelectorAll('.deleteButton').forEach(button => {
    button.addEventListener('click', (event) => {
        let id = event.target.getAttribute('data-id');
        deleteCartItem(id); // Gọi function để xoá sản phẩm
    });
});

// Hàm được gọi khi trang được load để tính và cập nhật tổng tiền của mỗi sản phẩm và tổng tiền của giỏ hàng
window.onload = function() {
    updateItemTotal();
    updateTotalCartValue();
};
</script>

