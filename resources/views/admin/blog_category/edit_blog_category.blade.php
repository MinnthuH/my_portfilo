@extends('admin.adminMaster')

@section('admin')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Add Blog Category Page</h4>

                            <form action="{{ route('update#blogCategory') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $blogCategory->id }}">
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog Category
                                        Name</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="blogCategory"
                                            id="example-text-input" value="{{ $blogCategory->blog_category }}">
                                        @error('blogCategory')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end row -->
                                <input class="btn btn-info waves-effect waves-light" type="submit"
                                    value="Update Blog Category">
                            </form>

                        </div>

                    </div>
                </div>
            @endsection
