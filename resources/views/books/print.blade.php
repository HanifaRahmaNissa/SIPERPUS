<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Buku Perpustakaan</title>
    <style>
        th, td{
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1 style="text-align: center;">List Buku Perpustakaan</h1>
    </header>
    <section>
        <table border="1" style="border-collapse: collapse; margin: 0px 10px 0px 10px" >
            <thead>
                <th>No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tahun Terbit</th>
                <th>Penerbit</th>
                <th>Kota Terbit</th>
                <th>Cover</th>
                <th>Rak Buku</th>
            </thead>
            <tbody style="text-align: center;">
                @foreach ($books as $book)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$book->title}}</td>
                        <td>{{$book->author}}</td>
                        <td>{{$book->year}}</td>
                        <td>{{$book->publisher}}</td>
                        <td>{{$book->city}}</td>
                        <td><img width="75%" src="{{public_path('storage/cover_buku/'.$book->cover)}}" alt=""></td>
                        <td>{{$book->bookshelf->name}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>
</html>