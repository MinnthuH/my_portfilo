@extends('admin.adminMaster')

@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Blog Category Page</h4>

                            <form action="{{ route('store#blogCategory') }}" id="myForm" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog Category
                                        Name</label>
                                    <div class="col-sm-10 form-group">
                                        <input class="form-control" type="text" name="blogCategory"
                                            id="example-text-input">

                                    </div>
                                </div>
                                <!-- end row -->
                                <input class="btn btn-info waves-effect waves-light" type="submit"
                                    value="Add Blog Category">
                            </form>

                        </div>

                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#myForm').validate({
                            rules: {
                                blogCategory: {
                                    required: true,
                                },
                            },
                            messages: {
                                blogCategory: {
                                    required: 'Please Enter Blog Category',
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
