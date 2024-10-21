
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
          <h2>Delicious Coffee Is Here <i class="fa-solid fa-arrow-down"></i></h2>
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
                  <p>{{$categories[$i]->products[$j]['price']}} EG
                    <i class="h3"><span class="mdi mdi-heart-outline"></span></i>
                  </p>
                  <div style="text-align:center;">
                    <button class="btn btn-light incrementView" data-bs-toggle="offcanvas" data-bs-target="#{{$categories[$i]->products[$j]['name']}}"  data-product-id="{{ $categories[$i]->products[$j]['id']}}">Quick View</button>
                  </div>
                </div>
              </div>
            </div>
            <div id="{{$categories[$i]->products[$j]['name']}}" class="offcanvas offcanvas-top mt-5 mx-auto" style="width:700px; height:600px;">
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
                      <span style="color:#E59A59" class="price{{$categories[$i]->products[$j]['id']}}"></span>
                    </h2>
                    <p style="text-align:justify;">{{$categories[$i]->products[$j]['description']}}</p>
                    <hr>
                    @if(count($categories[$i]->products[$j]['variants']) > 0)
                      <select class="variant-select" >
                        @foreach($categories[$i]->products[$j]['variants'] as $variant)
                            <option value="{{$variant['id']}}" {{ $loop->first ? 'selected' : '' }}>{{$variant['name']}}</option>
                        @endforeach
                      </select>
                      <div id="{{$categories[$i]->products[$j]['id']}}" class="subOptions"></div>
                    @endif
                    <hr>
                    <div style="text-align:center; margin-top:50px;">
                      <button class="btn btn-primary" style="background-color:#E59A59; color:white; border:3px solid #E59A59;">Add to Cart</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.incrementView').click(function() {
      var productId = $(this).data('product-id'); // Get product ID

      $.ajax({
        url: '/products/increment-view/'+productId, // Replace with your route
        type: 'get',
        success: function(response) {
          // Handle success (e.g., show a success message)
          //console.log(response);
          //alert('View count incremented successfully!');
        },
        error: function(xhr) {
          // Handle error
          console.error(xhr);
          alert(xhr);
        }
      });
    });
  });
</script>
@php $locale = app()->getLocale(); @endphp
<script>
    $(document).ready(function() {
        const locale = '{{ $locale }}';
        function fetchVariantDetails(variantId) {
            if (variantId) {
                $.ajax({
                    url: `/variant/${variantId}`,
                    method: 'GET',
                    success: function(response) {
                        const variant = response.data;
                        let variantDetails = '#' + variant.product_id;
                        let detailsHtml = ``;

                        if (variant.sub_options && variant.sub_options.length) {
                            detailsHtml += '<ul>';
                            variant.sub_options.forEach(subOption => {
                                detailsHtml += `<li>${subOption.option.name[locale]} : ${subOption.name[locale]}</li>`;
                            });
                            detailsHtml += '</ul>';
                        }

                        $('.price'+variant.product_id).html(variant.price);
                        $(variantDetails).html(detailsHtml);
                        //$('#product-price').html(variant.price);
                    },
                    error: function() {
                      
                        $(variantDetails).html('<p>Error fetching variant details.</p>');
                    }
                });
            } else {
                $(variantDetails).empty();
            }
        }

        // Fetch details for the default selected product on page load
        $('.variant-select').change(function() {
            const variantId = $(this).val();
            const productId = $(this).data('product-id');
            const detailsContainer = $(this).closest('.offcanvas').find('.variant-details');
            fetchVariantDetails(variantId, productId, detailsContainer);
        });

        // Trigger change event on page load for all variant selects
        $('.variant-select').each(function() {
            $(this).change();
        });
    });
</script>

