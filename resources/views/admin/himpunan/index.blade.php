@extends('admin.dashboard.layout.main')



@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Project Himpunan</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success col-lg-10" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive col-lg-12 mb-5">
        @if (auth()->user()->role == 'Admin')
            <a href="{{ route('himpunan.create') }}" class="btn btn-secondary mb-3 shadow">+ Tambah Data</a>
        @endif
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Variabel ID</th>
                    <th scope="col">Himpunan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $project)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $project->variabel->variabel }}</td>
                        <td>{{ $project->himpunan }}</td>
                        <td>
                            <a href="{{ route('himpunan.show', $project->id) }}" class="badge bg-primary">Detail</a>
                            @if (auth()->user()->role == 'Admin')
                                <a href="{{ route('himpunan.edit', $project->id) }}" class="badge bg-warning">Edit</a>
                                <form action="{{ route('himpunan.destroy', $project->id) }}" method="post"
                                    class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button class="badge bg-danger border-0"
                                        onclick="return confirm ('Are you sure ?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
