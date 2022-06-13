<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Upload Image</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  </head>
  <body>
  <div class="container mt-5">

    @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif

    <div class="card">

      <div class="card-header text-center font-weight-bold">
        <h2>Upload Image</h2>
      </div>

      <div class="card-body">
          <form method="POST" enctype="multipart/form-data" action="{{ route('image.store') }}" >
            @csrf
              <div class="row">

                  <div class="col-md-12">
                      <div class="form-group">
                          <input type="file" name="image" placeholder="Choose image" accept="image/*">
                      @error('image')
                          <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                      @enderror
                      </div>
                  </div>

                  <div class="col-md-12 mt-2">
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
              </div>
          </form>

      </div>

    </div>

  </div>
  <div class="container mt-5">

    <div class="card">

      <div class="card-header text-center font-weight-bold">
        <h2>View Image</h2>
      </div>

      <div class="card-body">
        <table class="table table-striped">
          <tr>
            <th>Original Image</th>
            <th>Small Thumbnail Image (150*93)</th>
            <th>Medium Thumbnail Image (300*185)</th>
            <th>Large Thumbnail Image (550*340)</th>
          </tr>
          @foreach($allImages as $allImage)
          <tr>
            @foreach($allImage as $image)
              <td>
                <img src="{{ asset($image->path) }}" alt="" height="100" width="100">
              </td>
            @endforeach
          </tr>
          @endforeach
        </table>
      </div>

    </div>

  </div>
  </body>
</html>
