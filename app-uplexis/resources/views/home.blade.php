@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row alert alert-success">
            <div class="col-sm-10">
                <form action="{{route('getPosts')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-10 col-sm-12">
                            <strong>Buscar Posts: </strong>
                            <input type="text" name="wordToSearch" class="form-control" placeholder="Palavra Chave">
                        </div>
                        <div class="col-md-2 col-sm-12 mt-4">
                            <button type="submit" class="btn btn-sm btn-success">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <div class="row alert alert-success">
            <div class="col-md-3 col-sm-12">
                <h3>Lista de Posts</h3>
            </div>
            <div class="col-md-9 col-sm-12 mt-2">
                @if ($message = Session::get('success'))
                    <h5 class="text-success">{{$message}}</h5>
                @endif
                @if($errors->any())
                    <h5 class="text-danger">{{$errors->first()}}</h5>
                @endif
            </div>
        </div>




        <div class="row alert alert-success">

            @if (count($posts) === 0)
                <div class="col-sm-12">
                    <h3> Nenhum post salvo</h3>
                </div>
            @else
                <div class="col-sm-12">
                    <table class="table table-hover table-sm">
                        <tr>
                            <th >Título</th>
                            <th>Link</th>
                            <th ></th>
                        </tr>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{$post->title}}</td>
                                <td><a href="{{$post->url}}" target="_blank"> Ver no Site </a></td>
                                <td>
                                    <form action="{{ route('deletePost', ['id' => $post->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger float-right">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>
                {!! $posts->links() !!}
            @endif
        </div>
    </div>

@endsection
