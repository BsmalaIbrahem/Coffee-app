<section class="contact" id="contact">
  <div class="heading">
    Contact <span>us</span>
  </div>
  <div class="row">
    <div class="col-md-5 py-3 py-md-0">
      <h3>Let's Get In Touch</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit nobis, modi alias suscipit molestiae amet!</p>
      @foreach($ContactMethods as $ContactMethod)
        @if($ContactMethod['type'] == 'Phone')
            <i class="fa-solid fa-phone"><span>{{$ContactMethod['value']}}</span></i><br><br>
        @elseif($ContactMethod['type'] ==  'Gmail')
            <i class="fa-solid fa-envelope"><span>{{$ContactMethod['value']}}</span></i><br><br>
        @else
            <i class="fa-solid fa-location-dot"><span>{{$ContactMethod['value']}}</span></i>
        @endif
      @endforeach
    </div>

    <div class="col-md-7 py-3 py-md-0">
      <form action="#">
        <div class="mb-3 mt-3">
          <input type="text" class="form-control" id="name" placeholder="Enter Name" required>
        </div>

        <div class="mb-3 mt-3">
          <input type="email" class="form-control" id="email" placeholder="Enter Email" required>
        </div>

        <div class="mb-3 mt-3">
          <input type="number" class="form-control" id="number" placeholder="Enter Number" required>
        </div>


         <textarea  class="form-control" id="comment" rows="5" name="text" placeholder="Enter Message" required></textarea>

         <button type="submit" class="order-btn">Send Message</button>
      </form>
    </div>
  </div>

</section>