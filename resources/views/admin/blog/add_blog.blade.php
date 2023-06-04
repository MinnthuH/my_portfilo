@extends('admin.adminMaster')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <style type="text/css">
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: #b70000;
            font-weight: 700px;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Blog Page</h4>

                            <form action="{{ route('store#blog') }}" id="myForm" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog Category
                                        Name</label>
                                    <div class="col-sm-10">

                                        <select class="form-select" aria-label="Default select example"
                                            name="blogCategoryId">
                                            <option selected="">Open this select menu</option>
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}">{{ $item->blog_category }}</option>
                                            @endforeach

                                        </select>

                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog title</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="blogTitle" id="example-text-input">

                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog tag</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="blogTag" id="example-text-input"
                                            value="home,tech" data-role="tagsinput">
                                        @error('blogTag')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog
                                        Description</label>
                                    <div class="col-sm-10">
                                        <textarea id="elm1" name="blogDescription"></textarea>
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog Image</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" name="blogImage" id="image">
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <img class="rounded avatar-lg" id="showImage" src="{{ url('upload/no_image.jpg') }}"
                                            alt="Card image cap">
                                    </div>
                                </div>
                                <!-- end row -->
                                <input class="btn btn-info waves-effect waves-light" type="submit"
                                    value="Insert Blog Data">
                            </form>

                        </div>

                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#image').change(function(e) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $('#showImage').attr('src', e.target.result);
                            }
                            reader.readAsDataURL(e.target.files['0']);
                        });
                    });

                    $(document).ready(function() {
                        $('#myForm').validate({
                            rules: {
                                blogCategoryId: {
                                    required: true,
                                },
                                blogTitle: {
                                    required: true,
                                },
                                blogTag: {
                                    required: true,
                                },
                                blogDescription: {
                                    required: true,
                                },
                                blogImage: {
                                    required: true,
                                },
                            },
                            messages: {
                                blogCategoryId: {
                                    required: 'Please Enter Blog Category Id',
                                },
                                blogTitle: {
                                    required: 'Please Enter Blog Title Id',
                                },
                                blogTag: {
                                    required: 'Please Enter Blog Tag Id',
                                },
                                blogDescription: {
                                    required: 'Please Enter Blog Description Id',
                                },
                                blogImage: {
                                    required: 'Please Enter Blog Image Id',
                                },
                            },
                            errosElement: 'span',
                            errorPlacemente: function(error, element) {
                                errror.addClass('invalid-feedback');
                                element.closet('.form-group').append(error);
                            },
                            highlight: function(element, errorClass, validClass) {
                                $(element).addClass('is-invalid');
                            },
                            unhighlight: function(element, errorClass, validClass) {
                                $(element).removeClass('is-invalid');
                            },

                        });
                    });
                </script>

            @endsection
