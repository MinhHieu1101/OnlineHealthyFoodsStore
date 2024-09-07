$(document).ready(function() {
  $('.minus-button').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('.quantity').find('input[name="quantity"]');
    var value = parseInt($input.val());

    if (value > 1) {
      value -= 1;
    } else {
      value = 0;
    }

    $input.val(value).change();
  });

  $('.plus-button').on('click', function(e) {
    e.preventDefault();
    var $this = $(this);
    var $input = $this.closest('.quantity').find('input[name="quantity"]');
    var value = parseInt($input.val());

    if (value < 100) {
      value += 1;
    } else {
      value = 100;
    }

    $input.val(value).change();
  });

  $('input[name="quantity"]').on('change', function() {
    var $this = $(this);
    var newQuantity = $this.val();
    var productId = $this.closest('.item').data('product-id');

    $.ajax({
      type: 'POST',
      url: 'cart.php',
      data: {
        update_quantity_product_id: productId,
        quantity: newQuantity
      },
      success: function(data) {
        var itemTotal = data.item_total;
        var grandTotal = data.grand_total;
        
        $this.closest('.item').find('.total-price').text('$' + itemTotal);
        $('.total-value').text('$' + grandTotal);
      },
      error: function(error) {
        console.log('Error updating cart:', error);
      }
    });
  });

  $('.remove-product').on('click', function(e) {
    e.preventDefault();
    var productId = $(this).closest('.item').data('product-id');

    $.ajax({
      type: 'POST',
      url: 'cart.php',
      data: {
        remove_product_id: productId
      },
      success: function(data) {
        var grandTotal = data.grand_total;
        
        $('div[data-product-id="' + productId + '"]').remove();
        $('.total-value').text('$' + grandTotal);
      },
      error: function(error) {
        console.log('Error removing item from cart:', error);
      }
    });
  });
});