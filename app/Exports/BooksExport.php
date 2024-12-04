<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromArray, WithHeadings, ShouldAutoSize
{
      public function array(): array
    {
        $books = Book::all();
        $books_fillter = [];
        foreach($books as $key => $book){
            $books_fillter[$key]['no'] = $key+1;
            $books_fillter[$key]['judul'] = $book['title'];
            $books_fillter[$key]['penulis'] = $book['author'];
            $books_fillter[$key]['penerbit'] = $book['publisher'];
            $books_fillter[$key]['tahun'] = $book['year'];
            $books_fillter[$key]['kota'] = $book['city'];
            $books_fillter[$key]['rak'] = $book['bookshelf']->name;
        }
        return $books_fillter;
    }
    public function headings(): array{
        return [
            'no',
            'judul',
            'penulis',
            'penerbit',
            'tahun',
            'kota',
            'rak',
        ];
    }
}
