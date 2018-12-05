@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Links</div>
                    <div class="card-body">
                        <a href="{{ url('/links/create') }}" class="btn btn-success btn-sm" title="Add New Link">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        {!! Form::open(['method' => 'GET', 'url' => '/links', 'class' => 'form-inline my-2 my-lg-0 float-right', 'role' => 'search'])  !!}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search..."
                                   value="{{ request('search') }}">
                            <span class="input-group-append">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        {!! Form::close() !!}

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                <tr>
                                    <th>Link</th>
                                    <th>Short Link</th>
                                    <th>Available to</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($links as $item)
                                    <tr>
                                        <td>{{ $item->link }}</td>
                                        <td>
                                            <a href="{{ config('app.url')}}/{{$item->short_link }}"
                                               target="_blank">{{ config('app.url')}}/{{$item->short_link }}</a>
                                        </td>
                                        <td>{{ $item->available_to }}</td>
                                        <td>
                                            <a href="{{ url('/links/' . $item->id) }}" title="View Link">
                                                <button class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View
                                                </button>
                                            </a>
                                            <a href="{{ url('/links/' . $item->id . '/edit') }}" title="Edit Link">
                                                <button class="btn btn-primary btn-sm">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </button>
                                            </a>
                                            {!! Form::open([
                                                'method'=>'DELETE',
                                                'url' => ['/links', $item->id],
                                                'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="far fa-trash-alt"></i> Delete', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger btn-sm',
                                                    'title' => 'Delete Link',
                                                    'onclick'=>'return confirm("Confirm delete?")'
                                            )) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $links->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
