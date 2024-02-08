@extends('admin.dashboard.layout.main')
@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{$title}}</h1>
</div>

<div class="row">
  <div class="col-lg-12">

    <div class="card">
      <div class="card-body">
        <form method="post" action="{{ $data->route }}" enctype="multipart/form-data">
          @if (session('failed'))
              <div class="alert alert-danger mg-b-0" role="alert">
                  {{ session('failed') }}
              </div>
          @endif
          @csrf
          @if($data->type != 'create')
              @method('PUT')
          @endif
            <div class="mb-3">
              <label for="name" class="form-label">Nama</label>
              <input type="text" {{ $data->type == 'detail' ? 'disabled' : ''}} value='{{$data->nama ?? old('nama')}}' class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" required autofocus>
              @error('nama')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Tanggal Lahir</label>
                <input type="date" {{ $data->type == 'detail' ? 'disabled' : ''}} value='{{$data->birthDate ?? old('birthDate')}}' class="form-control @error('birthDate') is-invalid @enderror" id="birthDate" name="birthDate" required autofocus>
                @error('birthDate')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Alamat</label>
                <input type="text" {{ $data->type == 'detail' ? 'disabled' : ''}} value='{{$data->address ?? old('address')}}' class="form-control @error('address') is-invalid @enderror" id="address" name="address" required autofocus>
                @error('address')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
            </div>
            {{-- <div class="mb-3">
                <label for="name" class="form-label">Bobot</label>
                <input type="text" {{ $data->type == 'detail' ? 'disabled' : ''}} value='{{$data->bobot ?? old('bobot')}}' class="form-control @error('bobot') is-invalid @enderror" id="bobot" name="bobot" required autofocus>
                @error('bobot')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
            </div> --}}

            @if($data->type != 'detail')
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-danger">Reset</button>
            @elseif($data->type == 'edit')
              <a href="{{route('employee.edit', $data->id)}}"><button type="button" class="btn btn-primary">Edit</button></a>
            @endif
            <a href="{{route('employee.index')}}"><button type="button" class="btn btn-dark">Kembali</button></a>

        </form>
      </div>
    </div>

{{-- add jabatan code --}}

  </div>

  <div class="col-lg-6 d-none">
      <div class="card">
        <div class="card-body">
          <h4>Import Data</h4>

          <form method="post" action="{{ route('importData') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

              <label>Pilih file excel <a href="{{asset('template/Template Import.xlsx')}}" target="_blank">Download Template</a></label>
              <div class="form-group">
                  <input type="file" name="file" required="required">
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Import</button>
              </div>
          </form>
        </div>
      </div>
  </div>
</div>
<!-- {{-- <script>
  const tittle = document.querySelector('#tittle');
  const slug = document.querySelector('#slug');

  tittle.addEventListener('change', function (){
    fetch('/part1/checkSlug?tittle=' + tittle.value)
    .then(response => response.json())
    .then(data => slug.value = data.slug)
  });
</script> --}}
{{-- <script>
  document.addEventListener('trix-file-accept', function(e){
    e.preventDefault();
  })
</script> --}}
@endsection
@section ('scripts')

<script>
  ClassicEditor
      .create( document.querySelector( '#body' ) )
      .catch( error => {
          console.error( error );
      } );
</script> -->

@endsection
