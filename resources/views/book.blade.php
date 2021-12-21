@extends('layout')
  
@section('content')

<section class="filter-content">
    <div class="row">
        <div class="column large-12">

            <table>
                <tr>
                    <td><b><a href="/books">Alles anzeigen</a></b></td>
                    <td><b>Veröffentlichung</b></td>
                    <td><b>Schlagwörter</b></td>
                    <td><b>Preisklasse</b></td>
                    <td><b>Bewertung</b></td>
                    <td><b>Autor</b></td>
                    <td><b>Verlag</b></td>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>
                        @foreach($dateArr as $date) 
                            <a href="/books/date/{{ $date }}">{{ $date }}</a></br>
                        @endforeach 
                    </td>
                    <td>
                        @foreach($tagGroup as $tagName) 
                            <a href="/books/tag/{{ $tagName['name'] }}">{{ $tagName['name'] }}</a></br>
                        @endforeach 
                    </td>
                    <td>
                          <a href="/books/price/0-25">0 -  25 €</a></br>
                          <a href="/books/price/26-50">26 -  50 €</a></br>
                          <a href="/books/price/51-100">51 - 100 €</a></br>
                          <a href="/books/price/101-250">101 - 250 €</a></br>
                    </td>
                    <td>
                        <a href="/books/rate/1"><img src="{{ asset('images/icons/1star.png') }}" width="90px"></a></br>
                        <a href="/books/rate/2"><img src="{{ asset('images/icons/2star.png') }}" width="90px"></a></br>
                        <a href="/books/rate/3"><img src="{{ asset('images/icons/3star.png') }}" width="90px"></a></br>
                        <a href="/books/rate/4"><img src="{{ asset('images/icons/4star.png') }}" width="90px"></a></br>
                        <a href="/books/rate/5"><img src="{{ asset('images/icons/5star.png') }}" width="90px"></a></br>
                    </td>
                    <td>
                        @foreach($autGroup as $author) 
                            <a href="/books/author/{{ $author['author'] }}">{{ $author['author'] }}</a></br>
                        @endforeach 
                    </td>
                    <td>
                        @foreach($distGroup as $distributor) 
                            <a href="/books/distributor/{{ $distributor['distributor'] }}">{{ $distributor['distributor'] }}</a></br>
                        @endforeach 
                    </td>
                </tr>
            </table>

        </div>
    </div>
</section>                   
<section class="blog-content">
       <div class="row">
            <div class="column large-12">
						
                <div class="blog-post-listing">
                    <table>

						<tr>

                            @foreach($books as $book)
                            
                                <td>
                                    <article class="blog-post">

                                        <div class="blog-post__header">
                                            <h3 class="blog-post__title">
                                                @foreach($photos as $photo)
                                                    @if($book['id'] == $photo['book_id'])
                                                        <img src="{{ asset('images/uploads/'.$photo['path']) }}">
                                                    @endif 
                                                @endforeach  
                             
                                                {{ $book['title'] }}
                                            </h3>
                                            
                                            <div class="blog-post__meta">

                                                <div class="blog-post__date">
                                                    {{ date('d.m.Y', strtotime($book['release_date'])) }}</br>
                                                    {{ $book['price'] }} €</br>
                                                    <a href="/books/rate/{{$book['rate']}}"><img src="{{ asset('images/icons/'.$book['rate'].'star.png') }}" width="90px"></br>
                                                </div>
                            
                                                <p class="blog-post__cat">
                                                    @foreach($tags as $tag)
                                                        @if($book['id'] == $tag['book_id'])
                                                        <a href="/books/tag/{{ $tag['name'] }}">{{ $tag['name'] }}</a>
                                                        @endif 
                                                    @endforeach  
                                                </p>
                            
                                            </div>
                                        </div>

                                    </article> 
                                </td>
                                @if(($loop->index+1) % 4 == 0 && $loop->index != 0)
                                    </tr><tr>
                                @endif

                            @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection