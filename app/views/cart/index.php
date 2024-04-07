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
        echo "<h2>Danh sách giỏ hàng</h2>";
        echo "<table id='cartTable' class='display'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Name</th>";
        echo "<th>Price</th>";
        echo "<th>Image</th>";
        echo "<th>Quantity</th>";
        echo "<th>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($_SESSION['cart'] as $item) {
            echo "<tr>";
            echo "<td>$item->id</td>";
            echo "<td>$item->name</td>";
            echo "<td>$item->price</td>";
            echo "<td><img src='/QLBanXe/$item->image' alt='Product Image' style='width:100px; height:100px;'></td>";
            echo "<td>
                    <form class='updateForm' data-id='$item->id' method='POST'>
                        <input name='id' type='hidden' value='$item->id' /> 
                        <input name='quantity' type='number' value='$item->quantity' class='quantityInput'/>
                        <input type='submit' value='update' class='btn btn-info' />
                    </form>
                </td>";
            echo "<td>
                    <button class='btn btn-danger deleteButton' data-id='$item->id'>Delete</button>
                </td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo '<p id="totalCartValue">Total Cart Value: </p>';
        echo "<form action='/QLBanXe/order/showCheckoutForm' method='post'>";
        echo "<input type='submit' value='Checkout'>";
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

        fetch('../QLBanXe/cart/updateQuantity/', {
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
