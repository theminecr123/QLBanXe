    <?php
    include_once 'app/views/share/header.php';

    $totalCartValue = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $totalCartValue += $item->price * $item->quantity;
        }
    }

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Giỏ hàng trống!";
} else {
    echo "<h2 class='list-cart'>Danh sách giỏ hàng</h2>";
    echo "<table id='cartTable' class='display'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th class='table-header'>ID</th>";
    echo "<th class='table-header'>Name</th>";
    echo "<th class='table-header'>Price</th>";
    echo "<th class='table-header'>Image</th>";
    echo "<th class='table-header'>Quantity</th>";
    echo "<th class='table-header' id='item-action'>Action</th>";
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
                <form class='updateForm' data-id='$item->id'>
                    <input class='input-quality' name='quality' type='number' value='$item->quantity' class='quantityInput'/></br>
                    <input class='input-update' type='submit' value='Update' class='btn btn-info' />
                </form>
            </td>";
        echo "<td>
                <button class='button-delete' data-id='$item->id'>
                <span class='text'>Delete</span>
                <span class='icon'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><path d='M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z'></path></svg></span>
                </button>
            </td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

    echo "<p class='table-header' id='total-cart'>Total Cart Value: $totalCartValue</p>";

    echo "<form action='/QLBanXe/order/showCheckoutForm' method='post'>";
    // echo "<input class='button-checkout' type='submit' value='Checkout'>";
    echo '<button class="button-checkout" style="margin-left: 30px;">
    <span>Checkout</span><i></i>
    </button>';
    echo "</form>";
}

    include_once 'app/views/share/footer.php';
    ?>

    <script>
        calculateTotalCartValue();
        
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', (event) => {
                let id = event.target.getAttribute('data-id');
                deleteCartItem(id); 
            });
        });

        function deleteCartItem(id) {
            fetch('/QLBanXe/cart/deleteItem/' + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    console.error('Xoá sản phẩm không thành công');
                }
            })
            .catch(error => {
                console.error('Lỗi: ', error);
            })
            .finally(() => {
                calculateTotalCartValue();
            });
        }

        document.querySelectorAll('.updateForm').forEach(form => {
            form.addEventListener('submit', (event) => {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của form
                let id = form.getAttribute('data-id');
                let quantity = form.querySelector('.quantityInput').value;
                updateCartItem(id, quantity);
            });
        });

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
            console.log(data);
        })
        .catch(error => {
            console.error('Lỗi: ', error);
        })
        .finally(() => {
            calculateTotalCartValue(); 
        });
    }
    
    function calculateTotalCartValue() {
        let total = 0;
        document.querySelectorAll('.display tbody tr').forEach(row => {
            let price = parseFloat(row.querySelector('td:nth-child(3)').textContent);
            let quantity = parseInt(row.querySelector('.quantityInput').value);
            total += price * quantity;
        });
        document.getElementById('totalCartValue').textContent = "Total Cart Value: " + total;
    }
</script>
