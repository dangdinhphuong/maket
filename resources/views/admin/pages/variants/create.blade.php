@extends('admin.master')
@section('title', 'Têm danh mục')
@section('style')
    <style>

    </style>
@endsection
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh mục biến thể</h1>
        <a href="{{ route('cp-admin.variant.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            Danh mục</a>
    </div>

    <div class="card shadow mb-4 ">
        <div class="card-body">
            <div class="table-responsive">
                <form class="user" action="{{ route('cp-admin.variant.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <label for="namegories">Tên danh mục <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control form-control-user" id="name"
                                onchange="ChangeToSlug('name','slugs')" value="{{ old('name') }}" name="name"
                                id="namegories" placeholder="Tên danh mục ...">
                            @error('name')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="slugCategories">Loại giá trị input<span class="text-danger">(*)</span></label>
                            <select class="form-control"name="type" disabled>
                                <option value="text">Text</option>
                                <option value="color">Color</option>
                                <option value="number">Number</option>
                            </select>
                            @error('type')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-4">
                            <label for="slugCategories">Slug danh mục</label>
                            <input type="text" class="form-control form-control-user" id="slugs"
                                value="{{ old('slug') }}" name="slug" id="slugCategories"
                                placeholder="Slug danh mục ...">
                            @error('slug')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
    <script src="{{ asset('admin/js/slug.js') }}"></script>
@endsection
