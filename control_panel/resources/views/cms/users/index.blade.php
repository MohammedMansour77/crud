@extends('cms.parent')
@section('title', 'Users')
@section('content')
    <section class="content">
        <section class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Users Table</h3>

                            <div class="card-tools">
                                <form action="{{ route('users.search') }}" method="get">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="search" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>UserName</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if (!is_null($user->address))
                                                    <strong>{{ $user->address }}</strong>
                                                @else
                                                    <span style="color:red;">NO Address</span>
                                                @endif
                                            </td>
                                            <td><span class="tag tag-success">{{ $user->created_at ?? '-' }}</span></td>
                                            <td style="display:flex;flex-direction:row">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    style="display: inline-block;"><i class=" fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('users.delete', $user->id) }}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit"
                                                        style="border:none;background-color: transparent;display: inline-block;"><i
                                                            class=" fas fa-trash-alt" style="color: red;"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
        </section>
    </section>

    <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
@endsection
