@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Categories</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->parent ? $category->parent->name : '' }}</td>
                                        <td>
                                        {{-- membatasi user untuk akses  --}}
                                        @can('edit_categories')
                                        <a href="{{ url('admin/categories/'.$category->id.'/edit')}}" class="btn btn-warning">Edit</a>
                                        @endcan
                                        {{-- //sebuah form yang memiliki method delete --}}
                                        {{-- Form::adalah collectivehtml --}}
                                        @can('delete_categories')
                                        {!! Form::open(['url' => 'admin/categories/'. $category->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                                        {!! Form::hidden('_method', 'DELETE') !!}
                                        {!! Form::submit('Remove', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                        @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    </div>
                    @can('add_categories')
                    <button class="card-footer text-right">
                    <a href="{{ route('categories.create')}}" class="btn btn-primary">Add new</a>
                    </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
