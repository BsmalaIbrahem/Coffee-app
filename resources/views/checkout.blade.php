
@if(session('message'))
  <x-alert level="info" message="{{session('message')}}" />
@endif
@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')


<style>
    .order-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        background-color: #ffffff;
        max-width: 400px;
        margin: auto;
        font-size: 14px;
    }
    .order-header {
        color: #333;
        font-weight: bold;
    }
    .product-details {
        font-size: 15px;
        color: #666;
    }
    .price {
        font-weight: bold;
        color: #333;
    }
    .total-price {
        font-weight: bold;
        font-size: 1.2em;
    }
    .btn-checkout {
        background-color: #333;
        color: #fff;
        border-radius: 8px;
        padding: 10px;
        width: 100%;
        font-weight: bold;
        border: none;
    }
    .text-muted-small {
        font-size: 0.85em;
        color: #999;
    }
</style>


<div class="order-card mt-5">
    <h5 class="order-header mb-4">Order Summary</h5>
    
    <!-- Product Info -->
    <div class="mb-3">
        <div class="product-details mb-1 d-flex justify-content-between mt-2">
            <span>Your Address</span>
            <button class="add-address" data-bs-toggle="offcanvas"  data-bs-target="#add" style="background:none; border:0; color:#E59A59;">
                @if($address)    
                    Update Address
                @else
                    Add Address
                @endif
            </button>
        </div>
        <div class="text-muted-small">
            @if($address)
                {{$address['details']}}
            @endif
        </div>
        <div class="d-flex justify-content-between mt-2">
            <span>Phone Number : 
                @if($phone)
                    {{$phone['phone']}}
                @endif
            </span>
            <button class="edit-phone" data-bs-toggle="offcanvas"  data-bs-target="#edit" style="background:none; border:0; color:#E59A59;">
                @if($phone)
                    Edit Phone
                @else
                    Add Phone
                @endif
            </button>
        </div>
    </div>
    
    <hr>
    
    <!-- Subtotal and Shipping -->
    <div class="d-flex justify-content-between">
        <span>Subtotal</span>
        <span class="price">{{$cart['total']}} EG</span>
    </div>
    <div class="d-flex justify-content-between mt-2">
        <span>Shipping</span>
        <span class="text-muted-small">{{$shipping_fee}} EG</span>
    </div>
    
    <hr>
    
    <!-- Total -->
    <div class="d-flex justify-content-between total-price mt-3 mb-4">
        <span>Total</span>
        <span>{{$cart['total'] + $shipping_fee}} EG</span>
    </div>
    
    
    <!-- Privacy Notice -->
    <p class="text-muted text-center text-muted-small mb-4">
        Your data will be used to process your order and support your experience as per our <a href="#" class="text-decoration-none">privacy policy</a>.
    </p>
    
    <!-- Place Order Button -->
     <form action="{{route('checkout')}}" method="post">
        @csrf
        <input type="text" name="phone_id" value="{{$phone['id']}}" hidden>
        <input type="text" name="address_id" value="{{$address['id']}}" hidden>
        <button class="btn btn-checkout">PLACE ORDER</button>
     </form>
    
</div>

<div id="add" class="offcanvas offcanvas-top mt-5 mx-auto" style="width:450px; height:500px;">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title">Add Address</h2>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <section class="login" style="width:80%;">
        <form method="POST" action="{{ route('add-address') }}">
            @csrf
            <div class="input">
                <label class="required">City</label>
                <select name="city_id" class="form-control form-control-lg">
                    @foreach($cities as $city)
                        <option value="{{$city['id']}}">{{$city['name']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="input">
                <label class="required">Street Name</label>
                <input type="text" placeholder="" name="street_name" class="form-control form-control-lg" value="{{$address['street_name'] ?? ''}}" required>
            </div>

            <div class="input">
                <label class="required">Building</label>
                <input type="text" placeholder="" name="building" class="form-control form-control-lg" value="{{$address['building'] ?? ''}}" required>
            </div>

            <div class="input">
                <label class="required">District</label>
                <input type="text" placeholder="" name="district" class="form-control form-control-lg" value="{{$address['district'] ?? ''}}" required>
            </div>

            <div class="input">
                <label>nearest landmark</label>
                <input type="text" placeholder="" name="nearest_landmark" class="form-control form-control-lg" value="{{$address['nearest_landmark'] ?? ''}}">
            </div>

            <div class="input">
                <label class="required">Address Type</label>
                <select name="address_type" class="form-control form-control-lg">
                    <option value="Home">Home</option>
                    <option value="Office">Office</option>
                </select>
            </div>

            <div>
                <input type="submit" value="Edit" class="btn btn-primary">
            </div>
        </form>
    </section>

</div>

<div id="edit" class="offcanvas offcanvas-top mt-5 mx-auto" style="width:450px; height:500px;">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title">Add Phone Number</h2>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <section class="login" style="width:80%;">
        <form method="POST" action="{{ route('add-phone') }}">
            @csrf
            <div class="input">
                <label class="required"> Your Phone Number</label>
                <input type="number" placeholder="" name="phone" class="form-control form-control-lg" value="{{$phone['phone'] ?? ''}}" required>
                <x-input-error :messages="$errors->get('bame')" class="mt-2" />
            </div>

            <div>
                <input type="submit" value="Add" class="btn btn-primary">
            </div>
        </form>
    </section>

</div>


@include('partials.footer')

@include('partials.scriptActions');

