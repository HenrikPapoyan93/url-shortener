@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Link {{ $link->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/links') }}" title="Back">
                            <button class="btn btn-warning btn-sm">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                            </button>
                        </a>
                        <a href="{{ url('/links/' . $link->id . '/edit') }}" title="Edit Link">
                            <button class="btn btn-primary btn-sm">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </button>
                        </a>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['links', $link->id],
                            'style' => 'display:inline'
                        ]) !!}
                        {!! Form::button('<i class="far fa-trash-alt"></i> Delete', array(
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-sm',
                                'title' => 'Delete Link',
                                'onclick'=>'return confirm("Confirm delete?")'
                        ))!!}
                        {!! Form::close() !!}
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <th> Link</th>
                                    <td> {{ $link->link }} </td>
                                </tr>
                                <tr>
                                    <th> Short Link</th>
                                    <td> <a href="{{ config('app.url')}}/{{$link->short_link }}"
                                            target="_blank">{{ config('app.url')}}/{{$link->short_link }}</a></td>
                                </tr>
                                <tr>
                                    <th> Available to</th>
                                    <td> {{ $link->available_to }} </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
