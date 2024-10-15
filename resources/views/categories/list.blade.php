<!-- vim: ft=html -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel final project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <div class="bg-dark py-3">
      <h3 class="text-white text-center">Laravel final project</h3>
    </div>
    <div class="container">
      <div class="row justify-content-center mt-4">
        <div class="col-md-10 d-flex justify-content-end">
          <a href="{{ route('products.index') }}" class="btn btn-dark">Product list</a>
          <a href="{{ route('categories.create') }}" class="btn btn-dark">Create</a>
        </div>
      </div>
      <div class="row d-flex justify-content-center">
        @if (Session::has('success'))
        <div class="col-md-10 mt-4">
          <div class="alert alert-success">
            {{ Session::get('success') }}
          </div>
        </div>
        @endif
        <div class="col-md-10">
          <div class="card borde-0 shadow-lg my-4">
            <div class="card-header bg-dark">
              <h3 class="text-white">Categories</h3>
            </div>
            <div class="card-body">
              <table class="table">
                <tr>
                  <th>Name</th>
                  <th>Created at</th>
                  <th>Action</th>
                </tr>
                @foreach ($categories as $c)
                <tr>
                  <td>{{ $c->name }}</td>
                  <td>{{ \Carbon\Carbon::parse($c->created_at)->format('d M Y') }}</td>
                  <td>
                    <a href="{{ route('categories.edit', $c->id) }}" class="btn btn-dark">Edit</a>
                    <a href="#" onclick="deleteCategory({{ $c->id }}, '{{ $c->name }}');" class="btn btn-danger">Delete</a>
                    <form id="delete-category-from-{{ $c->id }}" action="{{ route('categories.destroy', $c->id) }}" method="post">
                      @csrf
                      @method('delete')
                    </form>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      function deleteCategory(id, name) {
        if (confirm("Are you sure you want to delete category " + name + "?")) {
          document.getElementById("delete-category-from-" + id).submit();
        }
      }
    </script>
  </body>
</html>
