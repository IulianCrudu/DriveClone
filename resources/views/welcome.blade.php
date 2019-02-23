<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }


            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .photo {
                width: 300px;
                height: 300px;
            }
        </style>
    </head>
    <body>

    @if($directory=="/")
        <h1>Main Page</h1>
    @endif

    @if($directory!="/")
        <h1>{{$directory}} Folder</h1>
        <form action='{{"/".$directory}}' method="post">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="delete">
            <input type="submit" class="btn btn-danger" value="Delete Folder">
        </form>
    @endif
    <hr>
    <br>
        <div >
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif
        </div>
        <h1>Insert Your File Here: </h1>
        <form method="POST" enctype="multipart/form-data" action='{{$directory}}'  >
            {{csrf_field()}}
            <div class="form-group">
                <input type="file" name="fileName" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>

        <h1>Create a new Folder :</h1>
        <form method="post" action="/createFolder">
            {{csrf_field()}}
            <input type="hidden" name="parentDir" value={{$dirId}}>
            <div class="form-group">
                <label for="dirName">Enter Folder Name: </label>
                <input type="text" name="dirName" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
        @foreach($subDirs as $dir)
            {{--<form action='{{"/".$dir->name}}' method="get">--}}
                {{--{{csrf_field()}}--}}
                {{--<input type="hidden" name="directory" value={{$dir->name}}>--}}

                {{--<p type="submit" class="btn"><a href='{{"/".$dir->name}}'>{{$dir->name}}</a></p>--}}
                {{--<input type="submit" class="btn" value='{{$dir->name}}'>--}}
            {{--</form>--}}
            <p class="btn"><a href='{{"/".$dir->name}}'>{{$dir->name}}</a></p>
            <br>

        @endforeach
        <br>
        @foreach($files as $file)

            <a href={{'get/'.$file->id}}><img src='{{Storage::url($file->path)}}' class="photo"></a>
            <form action="/delete" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="id" value={{$file->id}}>
                <input type="submit" class="btn btn-danger" value="Delete this File">
            </form>
            <br>
        @endforeach()
    </body>
</html>
