@if(session('message'))
  <x-alert level="info" message="{{session('message')}}" />
@endif
@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')

<style>
    .direction{
        @if(session('language') == 'ar')
        text-align:right;
        @else
        text-align:left;
        @endif
    }
</style>
<div class="container mt-5 direction">
    <h2 class="mb-4">{{__('keywords.OrderDetails')}}</h2>

    <div class="card mb-4">
        <div class="card-header">
            {{__('keywords.OrderID')}}: <strong>#{{$order['reference_id']}}</strong>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{__('keywords.OrderInformation')}}</h5>
            <p><strong>{{__('keywords.TotalPrice')}}:</strong> {{$order['sub_total']}} {{__('keywords.EG')}}</p>
            <p><strong>{{__('keywords.OrderDate')}}:</strong> {{$order['created_at']}}</p>
            <p><strong>{{__('keywords.ShippingAddress')}}:</strong> {{$order['address']['details']}}</p>
        </div>
    </div>

    <h5 class="mb-3">{{__('keywords.orderProducts')}}</h5>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">{{__('keywords.ProductImage')}}</th>
                <th scope="col">{{__('keywords.ProductName')}}</th>
                <th scope="col">{{__('keywords.Quantity')}}</th>
                <th scope="col">{{__('keywords.Price')}}</th>
            </tr>
        </thead>
        <tbody style="text-align:center;">
            @foreach($order['products'] as $product)
            <tr>
                <td><img src="{{asset('/storage/'. $product['item']['main_image'])}}" class="me-3" style="width: 80px;"></td>
                <td class="align-middle">{{$product['item']['name']}}</td>
                <td class="align-middle">{{$product['quantity']}} Items</td>
                <td class="align-middle">{{$product['price']}} {{__('keywords.EG')}}</td>
            </tr>
            @endforeach
            <!-- Add more products as needed -->
        </tbody>
    </table>
</div>


@include('partials.footer')

@include('partials.scriptActions');


