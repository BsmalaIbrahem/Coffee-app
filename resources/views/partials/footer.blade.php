<footer id="footer">
  <div class="f-content">
    <div class="f-logo"><img src="{{asset('images/logo.png')}}" alt=""></div>
    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Iure illo, facilis fugit quisquam nihil ipsa.</p>
    @foreach($allSocialMedia as $SocialMedia)
        @if($SocialMedia['type'] == 'Instagram')
            <a href="{{$SocialMedia['value']}}"><i class="fa-brands fa-instagram"></i></a>
        @elseif($SocialMedia['type'] == 'Facebook')
            <a href="{{$SocialMedia['value']}}"><i class="fa-brands fa-facebook-f"></i></a>
        @elseif($SocialMedia['type'] == 'Whatsapp')
            <a href="https://wa.me/{{$SocialMedia['value']}}"><i class="fa-brands fa-whatsapp"></i></a>
        @elseif($SocialMedia['type'] == 'TikTook')
            <a href="{{$SocialMedia['value']}}"><i class="fa-brands fa-twitter"></i></a>
        @endif
    @endforeach
  </div>
  <br>
</footer>