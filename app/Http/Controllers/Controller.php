<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Photo;
use App\Models\Tag;
use App\Models\Taggable;
use File;
use DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
    public function create()
    {
        //
    }
    */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #Book::create($request->all()); // Endfassung

        #Testweise
        $book = new Book();
        $book->title = $request->title;
        $book->rate = $request->rate;
        $book->release_date = $request->release_date;
        $book->price = $request->price;
        $book->summary = $request->summary;
        $book->author = $request->author;
        $book->distributor = $request->distributor;
        $book->save();

        if($file = $request->file('cover')){

            $file_name = $file->getClientOriginalName();
            $file->move('images/uploads', $file_name);

            $photo = new Photo();
            $photo->book_id = $book->id; #Book::order('id','DESC')->first();
            $photo->path = $file_name; # GRÖßE: $file->getClientSize();
            $photo->save();

        }

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $book = Book::findOrFail($id);
        $book->title = $request->title;
        $book->rate = $request->rate;
        $book->release_date = $request->release_date;
        $book->price = $request->price;
        $book->summary = $request->summary;
        $book->author = $request->author;
        $book->distributor = $request->distributor;
        $book->update();

        if($file = $request->file('cover')){

            # Delete Image
            $photo = Photo::where('book_id', $id)->first();
            if($photo != null && $photo->path != null) 
            {
                $this->removeImage($photo->path);

                # Move Image
                $file_name = $file->getClientOriginalName();
                $file->move('images/uploads', $file_name);
                $photo->path = $file_name;
                $photo->update();
            }
            else
            {
                $file_name = $file->getClientOriginalName();
                $file->move('images/uploads', $file_name);
                
                $photo = new Photo();
                $photo->book_id = $book->id;
                $photo->path = $file_name;
                $photo->save();
            }
        
  
        }
        
        return $this->books(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
    /*
    |--------------------------------------------------------------------------
    | Library Project Code
    |--------------------------------------------------------------------------
    */
    public function showbooks()
    {
        return $this->books(false);
    }

    public function books($loggedInBool)
    {
        $books = Book::all(); #order by fehlt
        #dd($books);
        $photos = Photo::all();
        
        $tags = Tag::join( 'taggables', 'tags.id', '=', 'taggables.tag_id')
                            ->get(['tags.name', 'taggables.book_id']);

        $dateGroup = Book::select('release_date')->get()->toArray();
        $dateArr = [];
        foreach($dateGroup as $date)  $dateArr[] = substr($date['release_date'] , -4);
        $dateArr = array_unique($dateArr, SORT_STRING);
        sort($dateArr);

        $tagGroup = Tag::select('name')->groupBy('name')->get()->toArray();
        $rateGroup = Book::select('rate')->groupBy('rate')->get()->toArray();
        $autGroup = Book::select('author')->groupBy('author')->get()->toArray();
        $distGroup = Book::select('distributor')->groupBy('distributor')->get()->toArray();
        #dd($dateArr);

        $datagroup = compact('books', 'photos', 'tags', 'dateArr', 'tagGroup', 'rateGroup', 'autGroup', 'distGroup');
        #dd($datagroup);

        if($loggedInBool) return view('dashboard', $datagroup );
        else return view('book', $datagroup );
    }

    public function bookcreate()
    {
        return view('/manage');
    }

    public function bookdelete($id)
    {
        Book::where('id', $id)->forceDelete();
        $photo = Photo::where('book_id', $id)->first();
        #dd($photo);
        $this->removeImage($photo->path);
        $photo->forceDelete();
        
        return $this->books(true);
    }


    public function bookupdate($id)
    {
        $book = Book::findOrFail($id);
        return view('/manage', compact('book'));
    }

    public function removeImage(String $file_name)
    {
        if(File::exists(public_path('images/uploads/'.$file_name))){
            File::delete(public_path('images/uploads/'.$file_name));
        }
    }

    public function show_books_by_date($date)
    {
        $books = Book::where('release_date', 'LIKE','%'.$date.'%')->get();
        $photos = Photo::all();
        
        $tags = Tag::join( 'taggables', 'tags.id', '=', 'taggables.tag_id')
                            ->get(['tags.name', 'taggables.book_id']);

        $dateGroup = Book::select('release_date')->get()->toArray();
        $dateArr = [];
        foreach($dateGroup as $date)  $dateArr[] = substr($date['release_date'] , -4);
        $dateArr = array_unique($dateArr, SORT_STRING);
        sort($dateArr);

        $tagGroup = Tag::select('name')->groupBy('name')->get()->toArray();
        $rateGroup = Book::select('rate')->groupBy('rate')->get()->toArray();
        $autGroup = Book::select('author')->groupBy('author')->get()->toArray();
        $distGroup = Book::select('distributor')->groupBy('distributor')->get()->toArray();

        $datagroup = compact('books', 'photos', 'tags', 'dateArr', 'tagGroup', 'rateGroup', 'autGroup', 'distGroup');

        return view('book', $datagroup );
    }

    public function show_books_by_category($tag)
    {
        $tag_id = Tag::select('id')->where('name', 'LIKE','%'.$tag.'%')->get()->toArray();
        $taggable_ids = Taggable::select('book_id')->where('tag_id', '=', $tag_id)->get()->toArray();
        $books = Book::whereIn('id', array_values($taggable_ids))->get();
        $photos = Photo::all();
        #dd($books);

        $tags = Tag::join( 'taggables', 'tags.id', '=', 'taggables.tag_id')
                            ->get(['tags.name', 'taggables.book_id']);

        $dateGroup = Book::select('release_date')->get()->toArray();
        $dateArr = [];
        foreach($dateGroup as $date)  $dateArr[] = substr($date['release_date'] , -4);
        $dateArr = array_unique($dateArr, SORT_STRING);
        sort($dateArr);

        $tagGroup = Tag::select('name')->groupBy('name')->get()->toArray();
        $rateGroup = Book::select('rate')->groupBy('rate')->get()->toArray();
        $autGroup = Book::select('author')->groupBy('author')->get()->toArray();
        $distGroup = Book::select('distributor')->groupBy('distributor')->get()->toArray();

        $datagroup = compact('books', 'photos', 'tags', 'dateArr', 'tagGroup', 'rateGroup', 'autGroup', 'distGroup');

        return view('book', $datagroup );
    }
    

    public function show_books_by_pricerange($range)
    {
        $prices = explode('-', $range);
        $books = Book::whereBetween('price', [$prices[0], $prices[1]])->get();
        $photos = Photo::all();
        
        $tags = Tag::join( 'taggables', 'tags.id', '=', 'taggables.tag_id')
                            ->get(['tags.name', 'taggables.book_id']);

        $dateGroup = Book::select('release_date')->get()->toArray();
        $dateArr = [];
        foreach($dateGroup as $date)  $dateArr[] = substr($date['release_date'] , -4);
        $dateArr = array_unique($dateArr, SORT_STRING);
        sort($dateArr);

        $tagGroup = Tag::select('name')->groupBy('name')->get()->toArray();
        $rateGroup = Book::select('rate')->groupBy('rate')->get()->toArray();
        $autGroup = Book::select('author')->groupBy('author')->get()->toArray();
        $distGroup = Book::select('distributor')->groupBy('distributor')->get()->toArray();

        $datagroup = compact('books', 'photos', 'tags', 'dateArr', 'tagGroup', 'rateGroup', 'autGroup', 'distGroup');

        return view('book', $datagroup );
    }

    public function show_books_by_rate($rate)
    {
        $books = Book::where('rate', 'LIKE','%'.$rate.'%')->get();
        $photos = Photo::all();
        
        $tags = Tag::join( 'taggables', 'tags.id', '=', 'taggables.tag_id')
                            ->get(['tags.name', 'taggables.book_id']);

        $dateGroup = Book::select('release_date')->get()->toArray();
        $dateArr = [];
        foreach($dateGroup as $date)  $dateArr[] = substr($date['release_date'] , -4);
        $dateArr = array_unique($dateArr, SORT_STRING);
        sort($dateArr);

        $tagGroup = Tag::select('name')->groupBy('name')->get()->toArray();
        $rateGroup = Book::select('rate')->groupBy('rate')->get()->toArray();
        $autGroup = Book::select('author')->groupBy('author')->get()->toArray();
        $distGroup = Book::select('distributor')->groupBy('distributor')->get()->toArray();

        $datagroup = compact('books', 'photos', 'tags', 'dateArr', 'tagGroup', 'rateGroup', 'autGroup', 'distGroup');

        return view('book', $datagroup );
    }


    public function show_books_by_author($author)
    {
        $books = Book::where('author', 'LIKE','%'.$author.'%')->get();
        $photos = Photo::all();
        
        $tags = Tag::join( 'taggables', 'tags.id', '=', 'taggables.tag_id')
                            ->get(['tags.name', 'taggables.book_id']);

        $dateGroup = Book::select('release_date')->get()->toArray();
        $dateArr = [];
        foreach($dateGroup as $date)  $dateArr[] = substr($date['release_date'] , -4);
        $dateArr = array_unique($dateArr, SORT_STRING);
        sort($dateArr);

        $tagGroup = Tag::select('name')->groupBy('name')->get()->toArray();
        $rateGroup = Book::select('rate')->groupBy('rate')->get()->toArray();
        $autGroup = Book::select('author')->groupBy('author')->get()->toArray();
        $distGroup = Book::select('distributor')->groupBy('distributor')->get()->toArray();

        $datagroup = compact('books', 'photos', 'tags', 'dateArr', 'tagGroup', 'rateGroup', 'autGroup', 'distGroup');

        return view('book', $datagroup );
    }

    public function show_books_by_distributor($distributor)
    {
        $books = Book::where('distributor', 'LIKE','%'.$distributor.'%')->get();
        $photos = Photo::all();
        
        $tags = Tag::join( 'taggables', 'tags.id', '=', 'taggables.tag_id')
                            ->get(['tags.name', 'taggables.book_id']);

        $dateGroup = Book::select('release_date')->get()->toArray();
        $dateArr = [];
        foreach($dateGroup as $date)  $dateArr[] = substr($date['release_date'] , -4);
        $dateArr = array_unique($dateArr, SORT_STRING);
        sort($dateArr);

        $tagGroup = Tag::select('name')->groupBy('name')->get()->toArray();
        $rateGroup = Book::select('rate')->groupBy('rate')->get()->toArray();
        $autGroup = Book::select('author')->groupBy('author')->get()->toArray();
        $distGroup = Book::select('distributor')->groupBy('distributor')->get()->toArray();

        $datagroup = compact('books', 'photos', 'tags', 'dateArr', 'tagGroup', 'rateGroup', 'autGroup', 'distGroup');

        return view('book', $datagroup );
    }
}
