<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Add Company Form - Laravel 8 CRUD</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   </head>
   <body>
        <div class="container mt-2">            
            @if(session('message'))
            <div class="alert alert-danger mb-1 mt-1">
                {{ session('message') }}
            </div>
            @endif            
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left mb-2">
                    <h2>Add Company</h2>
                    </div>
                    <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('companies.index') }}"> Back</a>
                    </div>
                </div>
            </div>
            @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
            @endif
            <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" id="my-form">
                @csrf
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Company Name:</strong>
                        <input type="text" name="name" class="form-control" placeholder="Company Name" value="{{ old('name') }}">
                        @error('name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Company Email:</strong>
                        <input type="email" name="email" class="form-control" placeholder="Company Email" value="{{ old('email') }}">
                        @error('email')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Company Address:</strong>
                        <input type="text" name="address" class="form-control" placeholder="Company Address" value="{{ old('address') }}">
                        @error('address')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Add Profile:</strong>
                        <input type="file" name="image" class="form-control">
                        @error('image')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>
                </div>
            </form>
        </div>        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>

        <!-- Laravel Javascript Validation -->
        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
        {!! JsValidator::formRequest('App\Http\Requests\FormValidation', '#my-form'); !!}
   </body>
</html>