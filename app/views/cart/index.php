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
                <form class='updateForm' data-id='$item->id'>
                    <input name='quality' type='number' value='$item->quantity' class='quantityInput'/>
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

    echo "<p>Total Cart Value: $totalCartValue</p>";

    echo "<form action='/QLBanXe/order/showCheckoutForm' method='post'>";
    echo "<input type='submit' value='Checkout'>";
    echo "</form>";
}

include_once 'app/views/share/footer.php';
?>

<script>
$(document).ready(function() {
    $('#cartTable').DataTable({
        "columnDefs": [{
            "width": "20%",
            "targets": [0, 1, 2, 3]
        }]
    });

    $(document).on('submit', '.updateForm', function(event) {
        event.preventDefault();
        var id = $(this).data('id');
        var quantity = $(this).find('.quantityInput').val();
        $.ajax({
            url: '/QLBanXe/cart/updateQuality/' + id,
            type: 'POST',
            data: {
                'quality': quantity
            },
            success: function(response) {
                updateCartDisplay(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    $(document).on('click', '.deleteButton', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/QLBanXe/cart/deleteItem/' + id,
            type: 'POST',
            success: function(response) {
                updateCartDisplay(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    function updateCartDisplay(response) {
        if (response.hasOwnProperty('cart')) {
            $('#cartTable tbody').empty();
            response.cart.forEach(function(item) {
                var newRow = '<tr>' +
                    '<td>' + item.id + '</td>' +
                    '<td>' + item.name + '</td>' +
                    '<td>' + item.price + '</td>' +
                    '<td><img src="/QLBanXe/' + item.image + '" alt="Product Image" style="width:100px; height:100px;"></td>' +
                    '<td>' +
                    '<form class="updateForm" data-id="' + item.id + '">' +
                    '<input name="quality" type="number" value="' + item.quantity + '" class="quantityInput"/>' +
                    '<input type="submit" value="update" class="btn btn-info" />' +
                    '</form>' +
                    '</td>' +
                    '<td>' +
                    '<button class="btn btn-danger deleteButton" data-id="' + item.id + '">Delete</button>' +
                    '</td>' +
                    '</tr>';
                $('#cartTable tbody').append(newRow);
            });
        }
    }
});
</script>
