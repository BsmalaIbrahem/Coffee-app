@if(session('message'))
  <x-alert level="info" message="{{session('message')}}" />
@endif
@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')

<style>
   .select-container {
    box-sizing: border-box;
    display: flex;
    flex-wrap: wrap; /* Allow wrapping of selects */
    gap: 15px; /* Space between selects */
    padding:5px;
    }

    .form-select {
        width: 150px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        transition: border-color 0.3s, background-color 0.3s;
    }

    .form-select:hover {
        border-color: #007bff; /* Change border color on hover */
        background-color: #e9ecef; /* Lighten background on hover */
    }

    .form-select:focus {
        outline: none;
        border-color: #007bff; /* Focus border color */
        background-color: #fff; /* Reset background on focus */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Add shadow on focus */
    }

    /* Responsive styles */
    @media (max-width: 600px) {
        .form-select {
            flex: 1 1 calc(50% - 7.5px); /* Two selects per row with gap */
            min-width: 150px; /* Ensure a minimum width */
        }
    }

</style>

<section class="products">
  <h2 class="text-center py-3 bg-light" style="color:#212529c9; margin-bottom:30px;">{{request()->get('category') ?? request()->get('search_key') }}</h2>

  <div class="d-flex justify-content-center">
        <div class="select-container">
            @if(@$options)
            @foreach($options as $option)
                <select class="form-select">
                    @foreach($option->subOptions as $sub_option)
                        @if($loop->first)
                            <option hidden>{{$option['name']}}</option>
                        @endif
                        <option value="{{$sub_option['id']}}">{{$sub_option['name']}}</option>
                    @endforeach
                </select>
            @endforeach
            @endif
        </div>
  </div>


  <section class="menu" id="menu">
    <div class="row" style="margin-top: 30px;">
        @foreach($products as $product)
            <div class="col-6 col-md-6 py-3 py-md-0">
                <div class="card card-product">
                    <img src='{{asset("/storage/".$product["main_image"])}}' alt="" class="card-img-top">
                    <div class="card-body">
                        <h3>{{$product['name']}}</h3>
                        <h6><hr></h6>
                        <p>
                            @if($product['price_after_discount'] > 0)
                                <del style="text-decoration: line-through;">{{$product['price']}} EG</del>
                                {{$product['price_after_discount']}} EG
                            @else
                                {{$product['price']}} EG
                            @endif
                            @if(!$product['wishlisted'])
                                <i class="h3 favorite-icon" data-id="{{$product['id']}}" onclick="toggleFavorite(this)">
                                  <span class="mdi mdi-heart-outline"></span>
                                </i>
                            @else
                                <i class="h3 destroy-favorite-icon" data-id="{{$product['id']}}" onclick="toggleFavorite(this)">
                                 <span class="mdi mdi-heart"></span>
                                </i>
                            @endif
                            </p>
                        <div style="text-align:center;">
                        <button class="btn btn-light" data-bs-toggle="offcanvas"  data-bs-target="#pro{{$product['id']}}"  data-product-id="{{$product['id']}}">Quick View</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="pro{{$product['id']}}" class="offcanvas offcanvas-top mt-5 mx-auto" style="width:700px; height:600px;">
                <div class="offcanvas-header">
                    <h2 class="offcanvas-title"></h2>
                    <button class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-5 d-flex justify-content-center">
                            <img src='{{asset("/storage/".$product["main_image"])}}' class="img-fluid"  alt="Product Image">
                        </div>
                        <div class="col-12 col-md-6" style="margin-right: 5px;">
                            <h2>
                            {{$product['name']}} 
                            </h2>
                            @if(count($product['variants']) > 0)
                            <h3><span style="color:#E59A59" class="price{{$product['id']}}"></span></h3>
                            @else
                            <h3><span style="color:#E59A59">
                                @if($product['price_after_discount'] > 0)
                                <del style="text-decoration: line-through;">{{$product['price']}} EG</del>
                                {{$product['price_after_discount']}} EG
                                @else
                                {{$product['price']}} EG
                                @endif
                            </span></h3>
                            @endif
                            <p style="text-align:justify;">{{$product['description']}}</p>
                            <hr>
                            @if(count($product['variants']) > 0)
                            <select class="variant-select direction" id="variant-select-{{$product['id']}}">
                                @foreach($product['variants'] as $variant)
                                    <option class="direction" value="{{$variant['id']}}" {{ $loop->first ? 'selected' : '' }}>{{$variant['name']}}</option>
                                @endforeach
                            </select>
                            <div id="{{$product['id']}}" class="subOptions direction"></div>
                            @endif
                            <hr>
                            <div style="text-align:center; margin-top:50px;">
                            <button 
                                class="btn btn-primary" 
                                onclick="addToCart({{$product['id']}})"  
                                style="background-color:#E59A59; color:white; border:3px solid #E59A59;"
                                >
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
        
        {{ $products->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
    </div>
  </section>
</section>

@include('partials.scriptActions');

@include('partials.footer')