
@if(session('message'))
  <x-alert level="info" message="{{session('message')}}" />
@endif
@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')

<section class="home" id="home">
  <div class="home-content">
    <h3>Claim Best Offer <br> On Fast <span>Cuppa Coffee</span></h3>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, quibusdam minus. Ea accusamus rem numquam.</p>
    <a href="#our-menu" id="home-btn">More Details</a>
  </div>
  <div class="img">
    <img src="images/header.jpg" alt="">
  </div>
</section>
  @for($i=0; $i< count($categories); $i++)
    @if(count($categories[$i]->products) > 0)
      <section class="menu" id="menu">
        <h3 class="text-center">{{$categories[$i]['name']}}</h3>
        @if($i==0)
          <h2 class="direction">{{__('keywords.Delicious_Coffee_Is_Here')}} <i class="fa-solid fa-arrow-down"></i></h2>
        @endif
        <div class="row" style="margin-top: 30px;">
          @if(count($categories[$i]->products) >=3)
            @php $len = 3 @endphp
          @else
             @php $len = count($categories[$i]->products) @endphp
          @endif
          @for($j=0 ; $j< $len; $j++)
            <div class="col-6 col-md-4 py-3 py-md-0">
              <div class="card">
                <img src='{{asset("/storage/".$categories[$i]->products[$j]["main_image"])}}' alt="" class="card-img-top">
                <div class="card-body">
                  <h3>{{$categories[$i]->products[$j]['name']}}</h3>
                  <h6><hr></h6>
                    <p>
                      @if($categories[$i]->products[$j]['price_after_discount'] > 0)
                        <del style="text-decoration: line-through;">{{$categories[$i]->products[$j]['price']}} EG</del>
                        {{$categories[$i]->products[$j]['price_after_discount']}} EG
                      @else
                        {{$categories[$i]->products[$j]['price']}} EG
                      @endif
                      @if(!$categories[$i]->products[$j]['wishlisted'])
                        <i class="h3 favorite-icon" data-id="{{$categories[$i]->products[$j]['id']}}" onclick="toggleFavorite(this)">
                          <span class="mdi mdi-heart-outline"></span>
                        </i>
                      @else
                        <i class="h3 destroy-favorite-icon" data-id="{{$categories[$i]->products[$j]['id']}}" onclick="toggleFavorite(this)">
                          <span class="mdi mdi-heart"></span>
                        </i>
                      @endif
                  </p>
                  <div style="text-align:center;">
                    <button class="btn btn-light incrementView" data-bs-toggle="offcanvas" data-bs-target="#pro{{$categories[$i]->products[$j]['id']}}"  data-product-id="{{ $categories[$i]->products[$j]['id']}}">{{__('keywords.Quick_View')}}</button>
                  </div>
                </div>
              </div>
            </div>
            <div id="pro{{$categories[$i]->products[$j]['id']}}" class="offcanvas offcanvas-top mt-5 mx-auto" style="width:700px; height:600px;">
              <div class="offcanvas-header">
                <h2 class="offcanvas-title"></h2>
                <button class="btn-close" data-bs-dismiss="offcanvas"></button>
              </div>
              <div class="container">
                <div class="row">
                  <div class="col-12 col-md-5 d-flex justify-content-center">
                    <img src='{{asset("/storage/".$categories[$i]->products[$j]["main_image"])}}' class="img-fluid" alt="Product Image">
                  </div>
                  <div class="col-12 col-md-6" style="margin-right: 5px;">
                    <h2>
                      {{$categories[$i]->products[$j]['name']}} 
                    </h2>
                    @if(count($categories[$i]->products[$j]['variants']) > 0)
                      <h3><span style="color:#E59A59" class="price{{$categories[$i]->products[$j]['id']}}"></span></h3>
                    @else
                      <h3><span style="color:#E59A59">
                        @if($categories[$i]->products[$j]['price_after_discount'] > 0)
                          <del style="text-decoration: line-through;">{{$categories[$i]->products[$j]['price']}} EG</del>
                          {{$categories[$i]->products[$j]['price_after_discount']}} EG
                        @else
                          {{$categories[$i]->products[$j]['price']}} EG
                        @endif
                      </span></h3>
                    @endif
                    <p style="text-align:justify;">{{$categories[$i]->products[$j]['description']}}</p>
                    <hr>
                    @if(count($categories[$i]->products[$j]['variants']) > 0)
                      <select class="variant-select direction" id="variant-select-{{$categories[$i]->products[$j]['id']}}">
                        @foreach($categories[$i]->products[$j]['variants'] as $variant)
                            <option class="direction" value="{{$variant['id']}}" {{ $loop->first ? 'selected' : '' }}>{{$variant['name']}}</option>
                        @endforeach
                      </select>
                      <div id="{{$categories[$i]->products[$j]['id']}}" class="subOptions direction"></div>
                    @endif
                    <hr>
                    <div style="text-align:center; margin-top:50px;">
                      <button class="btn btn-primary"
                          onclick="addToCart({{ $categories[$i]->products[$j]['id'] }})"  
                          style="background-color:#E59A59; color:white; border:3px solid #E59A59;"
                          >
                          {{__('keywords.Add_to_Cart')}}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endfor
        </div>
      </section>
      <div class="container">
          <div class="line" style="width: 100%; height: 2px; background-color: #E59A59;"></div>
      </div>
    @endif
@endfor

@include('contactUs')
@include('partials.footer')

@include('partials.scriptActions');


