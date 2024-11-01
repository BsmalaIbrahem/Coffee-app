@if(session('message'))
  <x-alert level="info" message="{{session('message')}}" />
@endif
@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')

<div class="container mt-5">
    <h2 class="mb-4">Order Details</h2>

    <div class="card mb-4">
        <div class="card-header">
            Order ID: <strong>#{{$order['reference_id']}}</strong>
        </div>
        <div class="card-body">
            <h5 class="card-title">Order Information</h5>
            <p><strong>Total Price:</strong> {{$order['sub_total']}}</p>
            <p><strong>Order Date:</strong> {{$order['created_at']}}</p>
            <p><strong>Shipping Address:</strong> {{$order['address']['details']}}</p>
        </div>
    </div>

    <h5 class="mb-3">Products in this Order</h5>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">Product Image</th>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody style="text-align:center;">
            @foreach($order['products'] as $product)
            <tr>
                <td><img src="{{asset('/storage/'. $product['item']['main_image'])}}" class="me-3" style="width: 80px;"></td>
                <td class="align-middle">{{$product['item']['name']}}</td>
                <td class="align-middle">{{$product['quantity']}} Items</td>
                <td class="align-middle">{{$product['price']}}</td>
            </tr>
            @endforeach
            <!-- Add more products as needed -->
        </tbody>
    </table>
</div>


@include('partials.footer')

@include('partials.scriptActions');


