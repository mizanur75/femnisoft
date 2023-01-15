<section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center mb-2 pb-3">
          <div class="col-md-7 text-center heading-section ftco-animate">
            <h2 class="mb-2">Latest Blog</h2>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
          </div>
        </div>
        <div class="row">
          @if($blogs)
          @foreach($blogs as $blog)
          <div class="col-md-4 ftco-animate">
            <div class="blog-entry">
              <!-- <a href="blog-single.html" class="block-20" style="background-image: url({{asset('web/images/image_1.jpg')}});">
              </a> -->
              <div class="text d-flex py-4">
                <div class="meta mb-3">
                  <div><a href="#">{{date('d M Y', strtotime($blog->created_at))}}</a></div>
                  <div><a href="#">Admin</a></div>
                  <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div>
                </div>
                <div class="desc pl-3">
                  <h3 class="heading"><a href="#">{{$blog->title}}</a></h3>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          @endif
        </div>
      </div>
    </section>


    <section class="ftco-section-parallax">
      <div class="parallax-img d-flex align-items-center">
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
              <h2>Subcribe to our Newsletter</h2>
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
              <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-8">
                  <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                      <input type="text" class="form-control" placeholder="Enter email address">
                      <input type="submit" value="Subscribe" class="submit px-3">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div id="map"></div>