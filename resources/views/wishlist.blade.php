@if(session('message'))
  <x-alert level="info" message="{{session('message')}}" />
@endif
@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')


<section class="products">

  <section class="menu" id="menu">
    <div class="row" style="margin-top: 30px;">
        @foreach($wishlists as $wishlist)
            <div class="col-6 col-md-6 py-3 py-md-0">
                <div class="card card-product">
                    <img src='{{asset("/storage/".$wishlist["product"]["main_image"])}}' alt="" class="card-img-top">
                    <div class="card-body">
                        <h3>{{$wishlist["product"]['name']}}</h3>
                        <h6><hr></h6>
                        <p>
                            @if($wishlist["product"]['price_after_discount'] > 0)
                                <del style="text-decoration: line-through;">{{$wishlist["product"]['price']}} EG</del>
                                {{$wishlist["product"]['price_after_discount']}} EG
                            @else
                                {{$wishlist["product"]['price']}} EG
                            @endif
                            @if(!$wishlist["product"]['wishlisted'])
                                <i class="h3 favorite-icon" data-id="{{$wishlist['product']['id']}}" onclick="toggleFavorite(this)">
                                <span class="mdi mdi-heart-outline"></span>
                                </i>
                            @else
                                <i class="h3 destroy-favorite-icon" data-id="{{$wishlist['product']['id']}}" onclick="toggleFavorite(this)">
                                <span class="mdi mdi-heart"></span>
                                </i>
                            @endif
                        </p>
                        <div style="text-align:center;">
                        <button class="btn btn-light" data-bs-toggle="offcanvas"  data-bs-target="#pro{{$wishlist['product']['id']}}"  data-product-id="{{$wishlist['product']['id']}}">Quick View</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="pro{{$wishlist['product']['id']}}" class="offcanvas offcanvas-top mt-5 mx-auto" style="width:700px; height:600px;">
                <div class="offcanvas-header">
                    <h2 class="offcanvas-title"></h2>
                    <button class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-5 d-flex justify-content-center">
                            <img src='{{asset("/storage/".$wishlist["product"]["main_image"])}}' class="img-fluid"  alt="Product Image">
                        </div>
                        <div class="col-12 col-md-6" style="margin-right: 5px;">
                            <h2>
                            {{$wishlist["product"]['name']}} 
                            </h2>
                            @if(count($wishlist["product"]['variants']) > 0)
                            <h3><span style="color:#E59A59" class="price{{$wishlist['product']['id']}}"></span></h3>
                            @else
                            <h3><span style="color:#E59A59">
                                @if($wishlist["product"]['price_after_discount'] > 0)
                                <del style="text-decoration: line-through;">{{$wishlist["product"]['price']}} EG</del>
                                {{$wishlist["product"]['price_after_discount']}} EG
                                @else
                                {{$wishlist["product"]['price']}} EG
                                @endif
                            </span></h3>
                            @endif
                            <p style="text-align:justify;">{{$wishlist["product"]['description']}}</p>
                            <hr>
                            @if(count($wishlist["product"]['variants']) > 0)
                            <select class="variant-select direction" >
                                @foreach($wishlist["product"]['variants'] as $variant)
                                    <option class="direction" value="{{$variant['id']}}" {{ $loop->first ? 'selected' : '' }}>{{$variant['name']}}</option>
                                @endforeach
                            </select>
                            <div id="{{$wishlist['product']['id']}}" class="subOptions direction"></div>
                            @endif
                            <hr>
                            <div style="text-align:center; margin-top:50px;">
                            <button class="btn btn-primary" style="background-color:#E59A59; color:white; border:3px solid #E59A59;">
                                {{__('keywords.Add_to_Cart')}}
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        
        {{ $wishlists->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
    </div>
  </section>
</section>

@include('partials.scriptActions');

@include('partials.footer')