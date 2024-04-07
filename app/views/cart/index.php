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
                    '<td>'  + item.id + '</td>' +
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
