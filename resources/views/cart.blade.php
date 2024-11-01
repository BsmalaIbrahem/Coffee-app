@if(session('message'))
  <x-alert level="info" message="{{session('message')}}" />
@endif
@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')


<style>
    body {

    }
    .cart-container {
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .cart-item {
      border-bottom: 1px solid #ddd;
      padding: 15px 0;
    }
    .cart-item:last-child {
      border-bottom: none;
    }
    .cart-item .cart-image {
      width: 80px;
    }
    .product-details h5 {
      margin: 0;
      font-size: 1.1rem;
    }
    .discount-text {
      color: #d9534f;
      font-size: 0.9rem;
    }
    .price-strikethrough {
      text-decoration: line-through;
      color: #999;
      margin-right: 5px;
    }
    .cart-container .input-group {
      width: 120px;
    }
    .subtotal {
      font-size: 1.2rem;
      font-weight: bold;
    }
    .text-muted {
      font-size: 0.9rem;
    }
</style>

<div class="container mt-5">
  <div class="cart-container">
    <h3 class="mb-4">Shopping Cart</h3>

    @if($cart)
        <!-- Cart Header -->
        <div class="row fw-bold border-bottom pb-2">
        <div class="col-md-5">Product</div>
        <div class="col-md-2 text-center">Price</div>
        <div class="col-md-2 text-center">Quantity</div>
        <div class="col-md-3 text-end">Total</div>
        </div>

        @foreach($cart['products'] as $cart_product)
        <!-- Cart Item 1 -->
        @if($cart_product['price_after_discount'] > 0)
            <div class="row align-items-center cart-item" data-price="{{$cart_product['price_after_discount']}}">
        @else
          <div class="row align-items-center cart-item" data-price="{{$cart_product['price']}}">
        @endif
        <div class="col-md-5 d-flex align-items-center">
            <img class="cart-image" src="{{asset('/storage/'.$cart_product['product']['main_image'])}}" alt="Product Image" class="me-3">
            <div class="product-details">
            <h5 style="text-decoration:underline; cursor:pointer; color:#E59A59;"
                 data-bs-toggle="offcanvas" data-bs-target="#pro{{$cart_product['product']['id']}}"  
                 data-product-id="{{$cart_product['product']['id']}}"
            >
                {{$cart_product['product']['name']}}
            </h5>

            <div id="pro{{$cart_product['product']['id']}}" class="offcanvas offcanvas-top mt-5 mx-auto" style="width:700px; height:600px;">
              <div class="offcanvas-header">
                <h2 class="offcanvas-title"></h2>
                <button class="btn-close" data-bs-dismiss="offcanvas"></button>
              </div>
              <div class="container">
                <div class="row">
                  <div class="col-12 col-md-5 d-flex justify-content-center">
                    <img src="{{asset('/storage/'.$cart_product['product']['main_image'])}}" class="img-fluid" alt="Product Image">
                  </div>
                  <div class="col-12 col-md-6" style="margin-right: 5px;">
                    <h2>
                      {{$cart_product['product']['name']}}
                    </h2>
                    @if(count($cart_product['product']['variants']) > 0)
                      <h3><span style="color:#E59A59" class="price{{$cart_product['product']['id']}}"></span></h3>
                    @else
                      <h3><span style="color:#E59A59">
                        @if($cart_product['product']['price_after_discount'] > 0)
                          <del style="text-decoration: line-through;">{{$cart_product['product']['price']}} EG</del>
                          {{$cart_product['product']['price_after_discount']}} EG
                        @else
                          {{$cart_product['product']['price']}} EG
                        @endif
                      </span></h3>
                    @endif
                    <p style="text-align:justify;">{{$cart_product['product']['description']}}</p>
                    <hr>
                    @if(count($cart_product['product']['variants']) > 0)
                      <select class="variant-select" id="variant-select-{{$cart_product['product']['id']}}">
                        @foreach($cart_product['product']['variants'] as $variant)
                            <option value="{{$variant['id']}}" {{ $loop->first ? 'selected' : '' }}>{{$variant['name']}}</option>
                        @endforeach
                      </select>
                      <div id="{{$cart_product['product']['id']}}" class="subOptions"></div>
                    @endif
                    <hr>
                    <div style="text-align:center; margin-top:50px;">
                      <button class="btn btn-primary"
                          onclick="addToCart({{ $cart_product['product']['id'] }})"  
                          style="background-color:#E59A59; color:white; border:3px solid #E59A59;"
                          >
                          Add to Cart
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            @foreach($cart_product['variant']['subOptions'] as $sub_option)
                <p class="mb-1">{{$sub_option['option']['name']}}: {{$sub_option['name']}} {{$sub_option['unit'] ?? ''}}</p>
            @endforeach
            <form action="{{route('removeProduct', ['product_id' => $cart_product['id']])}}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit"  class="text-danger"  style="background:none; border:0;">Remove</a>
            </form>
            </div>
        </div>
        <div class="col-md-2 text-center">
            @if($cart_product['price_after_discount'] > 0)
                <span class="price-strikethrough">{{$cart_product['price']}} EG</span>
                <span>{{$cart_product['price_after_discount']}} EG</span>
            @else
                <span>{{$cart_product['price']}} EG</span>
            @endif
        </div>
        <div class="col-md-2 text-center">
            <div class="input-group">
            <button class="btn btn-outline-secondary minus-btn" data-id="{{$cart_product['id']}}">-</button>
            <input type="text" class="form-control text-center quantity-input"  value="{{$cart_product['quantity']}}">
            <button class="btn btn-outline-secondary plus-btn" data-id="{{$cart_product['id']}}">+</button>
            </div>
        </div>
        <div class="col-md-3 text-end">
            <span class="item-total">{{$cart_product['price'] * $cart_product['quantity']}}</span>
        </div>
        </div>

        @endforeach
        <!-- Cart Summary -->
        <div class="row mt-4">
        <div class="col-md-6">
            
        </div>
        <div class="col-md-6 text-end">
            <p class="subtotal">Subtotal: <span id="subtotal">458</span> EG</p>
            <p class="text-muted">Taxes and shipping calculated at checkout</p>
            <a href="{{route('checkout')}}" class="btn btn-dark btn-lg">CHECK OUT</a>
        </div>
        </div>
    </div>

    @else
        <h2 class="text-center">No Products</h2>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function updateSubtotal() {
    let subtotal = 0;
    $('.cart-item').each(function () {
      const price = parseFloat($(this).data('price'));
      const quantity = parseInt($(this).find('.quantity-input').val());
      const total = price * quantity;
      $(this).find('.item-total').text(total + ' EG');
      subtotal += total;
    });
    $('#subtotal').text(subtotal);
  }

  $('.plus-btn').click(function () {
    const input = $(this).siblings('.quantity-input');
    let value = parseInt(input.val());
    input.val(value + 1);
    updateSubtotal();

    const cartProductId = $(this).data('id');
    
    $.ajax({
        url: '{{ route('increment-quantity') }}', // Adjust to your route
        method: 'PATCH',
        data: {
            cart_product_id: cartProductId,
            _token: '{{ csrf_token() }}' // Include CSRF token
        },
        success: function(response) {
            // Handle success response (e.g., change icon)
            console.log(response);
        },
        error: function(xhr) {
            // Handle error response
            console.error(xhr.responseText);
        }
    });
  });

  $('.minus-btn').click(function () {
    const input = $(this).siblings('.quantity-input');
    let value = parseInt(input.val());
    if (value > 1) {
      input.val(value - 1);
      updateSubtotal();

      const cartProductId = $(this).data('id');

      $.ajax({
        url: '{{ route('decrement-quantity') }}', // Adjust to your route
        method: 'PATCH',
        data: {
            cart_product_id: cartProductId,
            _token: '{{ csrf_token() }}' // Include CSRF token
        },
        success: function(response) {
            // Handle success response (e.g., change icon)
            console.log(response);
        },
        error: function(xhr) {
            // Handle error response
            console.error(xhr.responseText);
        }
    });
    }
  });

  $('.quantity-input').on('input', function () {
    updateSubtotal();
  });

  $(document).ready(function () {
    updateSubtotal();
           
  });
</script>


@include('partials.footer')

@include('partials.scriptActions');

