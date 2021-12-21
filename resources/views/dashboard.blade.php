@extends('layout')
  
@section('content')
    <section class="dashboard-content">
       <div class="row_3">
            <div class="column large-12">
						
                <div class="blog-post-listing">
                    <table>
                        @foreach($books as $book)
                            <tr>
                            <td>
                                 @foreach($photos as $photo)
                                    @if($book['id'] == $photo['book_id'])
                                        <img src="{{ asset('images/uploads/'.$photo['path']) }}">
                                    @endif 
                                @endforeach  
                                </td>
                                <td>{{ $book['title'] }}</td>
                                <td>{{ $book['release_date'] }}</td>
                                <td>{{ $book['price'] }}</td>
                                <td>{{ $book['rate'] }}</td>
                                <td><a href="{{ url('/manage/'.$book['id']) }}">Bearbeiten</a></td>
                                <td><a href="{{ url('/delete/'.$book['id']) }}">Löschen</a></td>
                            </tr>
                        @endforeach  
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection