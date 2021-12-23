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
                    {{ isset($book)?'Update Book':'Create New Book'; }}
                    </h3>

                    @if(isset($book))
                        <form name="contactForm" id="contactForm" method="POST" action="/bookpost/{{ $book->id }}" autocomplete="off" enctype="multipart/form-data">
                        @method('put')
                    @else
                        <form name="contactForm" id="contactForm" method="POST" action="/bookpost" autocomplete="off" enctype="multipart/form-data">
                    @endif

                        {{ csrf_field() }}
                        <fieldset>

                            <div class="form-field">
                                <input name="title" id="title" class="h-full-width h-remove-bottom" placeholder="Title" value="{{ isset($book)?$book->title:''; }}" type="text">
                            </div>

                            <div class="form-field">
                                <select id="rate" name="rate" >
                                    <option value="5" style="background-image:url({{ asset('images/icons/5star.png') }})">5 Sterne - SEHR GUT</option>
                                    <option value="4" style="background-image:url({{ asset('images/icons/4star.png') }})">4 Sterne - GUT</option>
                                    <option value="3" style="background-image:url({{ asset('images/icons/3star.png') }})">3 Sterne - BEFRIEDIGEND</option>
                                    <option value="2" style="background-image:url({{ asset('images/icons/2star.png') }})">2 Sterne - AUSREICHEND</option>
                                    <option value="1" style="background-image:url({{ asset('images/icons/1star.png') }})">1 Sterne - SCHLECHT</option>
                                </select> 
                            </div>

                            <div class="form-field">
                                <input name="release_date" id="release_date" class="h-full-width h-remove-bottom" value="{{ isset($book)?$book->release_date:date('d.m.Y'); }}" type="text">
                            </div>

                            <div class="form-field">
                                <input name="author" id="author" class="h-full-width h-remove-bottom" placeholder="{{ isset($book)?$book->author:'Autor'; }}" value="{{ isset($book)?$book->author:'Autor'; }}" type="text">
                            </div>

                            <div class="form-field">
                                <input name="distributor" id="distributor" class="h-full-width h-remove-bottom" placeholder="{{ isset($book)?$book->distributor:'Verlag'; }}" value="{{ isset($book)?$book->distributor:''; }}" type="text">
                            </div>
                            <div class="form-field">
                                <input name="price" id="price" class="h-full-width h-remove-bottom" placeholder="{{ isset($book)?$book->price:'0.00'; }}" value="{{ isset($book)?$book->price:''; }}" type="text">
                            </div>

                            <div class="message form-field">
                                <textarea name="summary" id="summary" class="h-full-width h-remove-bottom" placeholder="Kurzfassung">{{ isset($book)?$book->summary:''; }}</textarea>
                            </div>

                            <div class="form-field">
                                <input type="file" name="cover" id="cover" class="h-full-width h-remove-bottom">
                            </div>

                            <input name="submit" id="submit" class="btn btn--primary btn-wide btn--large h-full-width" value="Save Book" type="submit">

                        </fieldset>
                    </form> <!-- end form -->

                </div>
                <!-- END respond-->

            </div> <!-- end comment-respond -->

        </div> <!-- end comments-wrap -->

    </div> <!-- end blog-content -->


@endsection

