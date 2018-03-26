@extends('layouts.app')

@section('title') Category view @endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">category {{ $category->id }}</div>
                <div class="panel-body">

                    <a href="{{ url('/admin/categories') }}" title="Back"><button class="btn btn-warning btn-xs"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                    <a href="{{ url('/admin/categories/' . $category->id . '/edit') }}" title="Edit category"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                    <form method="POST" action="{{ url('admin/categories' . '/' . $category->id) }}" accept-charset="UTF-8" style="display:inline">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-xs" title="Delete category" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                    </form>
                    <br/>
                    <br/>

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $category->id }}</td>
                                </tr>
                                @if (!empty($category->parent))
                                <tr>
                                    <th> Parent </th>
                                    <td> {{ $category->parent->name }} </td>
                                </tr>
                                @endif
                                <tr>
                                    <th> Name </th>
                                    <td> {{ $category->name }} </td>
                                </tr>
                                <tr>
                                    <th> Color </th>
                                    <td> <div style="background:{{ $category->color }};width:32px;height:32px;"></div> </td>
                                </tr>
                                <tr>
                                    <th> Cover Photo </th>
                                    <td> <img src="/storage/{{ $category->cover_photo }}" width="64" alt="{{ $category->name }}" /> </td>
                                </tr>
                                <tr>
                                    <th> Is Active </th>
                                    <td> {{ $category->is_active ? 'Yes' : 'No' }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
