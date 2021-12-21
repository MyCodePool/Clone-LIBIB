@extends('layout')
  
@section('content')

<!-- blog content
    ================================================== -->
    <div class="blog-content">

        <!-- comments
        ================================================== -->
        <div class="comments-wrap">

            <div class="row_3 comment-respond">

                <!-- START respond -->
                <div id="respond" class="column">

                    <h3>
                    Login 
                    </h3>


                    <form id="contactForm" action="{{ route('login.post') }}" method="POST">
                          @csrf
                          <div class="form-field">
                                  <input type="text" id="email_address"  class="h-full-width h-remove-bottom" name="email" placeholder="Your E-Mail Address" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                          </div>
  
                          <div class="form-field">
                              <div class="col-md-6">
                                  <input type="password" id="password"  class="h-full-width h-remove-bottom" name="password" placeholder="Your Password" required>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>


                          <input name="submit" id="submit" class="btn btn--primary btn-wide btn--large h-full-width" value="Submit" type="submit">
                      </form>

                </div>
                <!-- END respond-->

            </div> <!-- end comment-respond -->

        </div> <!-- end comments-wrap -->

    </div> <!-- end blog-content -->

@endsection