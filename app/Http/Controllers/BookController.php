<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Imports\BooksImport;
use App\Models\Book;
use App\Models\Bookshelf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    public function index(){
        $data['books'] = Book::with('bookshelf')->get();
        return view('books.index', $data);
    }

    public function create(){
        $data['bookshelves'] = Bookshelf::get();
        return view('books.create', $data);
    }
    public function edit(string $id){
        $data['bookshelves'] = Bookshelf::get();
        $data['book'] = Book::findOrFail($id);
        return view('books.edit', $data);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer|max:2024',
            'publisher' => 'required|max:255',
            'city' => 'required|max:50',
            'cover' => 'required',
            'bookshelf_id' => 'required',
        ]);
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'year' => $request->year,
            'publisher' => $request->publisher,
            'city' => $request->city,
            'cover' => $request->cover,
            'bookshelf_id' => $request->bookshelf_id
        ]);
        if($request->hasFile('cover')){
            $path =$request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_'.time() . '.' . $request->file('cover')->extension()
            );
            $validated['cover'] = basename($path);
        }
        Book::create($validated);

        $notification = array(
            'message' => 'data berhasil diupdate',
            'alert-type' => 'succes',
        );
        if($request->save == true) return redirect()->route('book')->with($notification);
        else return redirect()->route('book.create')->with($notification);
    }

    public function update(Request $request, string $id){
        $book = Book::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer|max:2024',
            'publisher' => 'required|max:255',
            'city' => 'required|max:50',
            'cover' => 'required',
            'bookshelf_id' => 'required',
        ]);
        if($request->hasFile('cover')){
            if($book->cover != null){
                Storage::delete('public/cover_buku'.$request->old_cover);
            }
            $path =$request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_'.time() . '.' . $request->file('cover')->extension()
            );
            $validated['cover'] = basename($path);
        }
        $book->update($validated);
    
        $notification = array(
            'message' => 'data berhasil dihapus',
            'alert-type' => 'succes',
        );
        return redirect()->route('book')->with($notification);
    }
    public function destroy(string $id){
        $book = Book::findOrFail($id);
        Storage::delete('public/cover_buku'.$book->cover);
        $book->delete();

        $notification = array(
            'message' => 'data buku berhasil dihapus',
            'alert-type' => 'succes'
        );
        return redirect()->route('book')->with($notification);
    }
    public function print (){
        $data['books'] = Book :: with('bookshelf')->get();
        $pdf = Pdf ::loadView('books.print', $data);
        return $pdf->download('book.pdf');
    }
    public function export () {
        return Excel::download(new BooksExport, 'books.xlsx');

    }
    public function import (Request $request) {
        Excel::import(new BooksImport,$request->file('file'));
        $notification = array (
            'massage' => 'Data buku berhasil',
            'alert-type' => 'succes'
        );
        return redirect()-> route('book') ->with($notification);

    }
}

