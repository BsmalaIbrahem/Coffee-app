@if(session('message'))
  <x-alert level="info" message="{{session('message')}}" />
@endif
@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')

<div class="container mt-5">
    <h2 class="mb-4">{{__('keywords.Orders')}}</h2>
    @if(count($orders) > 0)
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th scope="col">{{__('keywords.OrderID')}}</th>
                <th scope="col">{{__('keywords.Subtotal')}}</th>
                <th scope="col">{{__('keywords.Action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <th>#{{$order['reference_id']}}</th>
                    <th>{{$order['sub_total']}} EG</th>
                    <th>
                        <a href="{{route('order',['id' => $order['id']])}}" class="btn btn-primary btn-sm" style="background-color:E59A59; border:2px solid #E59A59;">View</a>
                    </th>
                </tr>
            @endforeach
            <!-- Add more rows as needed -->
        </tbody>
    </table>
    @else
     <h2 class="text-center">{{__('keywords.NoOrders')}}</h2>
    @endif
</div>

@include('partials.footer')

@include('partials.scriptActions');

