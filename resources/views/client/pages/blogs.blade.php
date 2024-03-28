@extends('client.master')
@section('title', 'Siêu thị thực phẩm')
@section('content')


    <!-- Blog Section Begin -->
    <section class="blog ">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="blog__sidebar">
                        <div class="blog__sidebar__search">
                        <form name="fillter_pro" class="" action="" method="get">
                        <input type="hidden" class="form-control bg-light border-0 small sreach" name="page" value="{{request('page') ? request('page') : '1' }}" aria-label="Search" aria-describedby="basic-addon2">
                        @if($categories_slug != "")
                                    <input type="hidden" name="Category_Blog" value="{{ $categories_slug->slug }}">
                                    @endif
                        <input type="text" value="{{ request('search') }}" name="search" placeholder="Search...">
                                <button id="fillter_pro"  type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="blog__sidebar__item categories1">
                            <h4>Danh mục bài viết</h4>
                            <ul>
                                @foreach($CategoryBlogs as $CategoryBlog)
                                <li class=" {{ !empty(request('Category_Blog')) && request('Category_Blog') == $CategoryBlog->slug ? 'active' :  ''  }} ">
                                    <a href="{{ route('blogs').'?Category_Blog='.$CategoryBlog->slug  }}">{{ $CategoryBlog->name }} ({{ $CategoryBlogs[4]->blogs->where('status', 1)->count() }})</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="row">
                    @foreach($blogs as $blog)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="{{asset('storage/' .$blog->image)}}" alt="">
                                </div>
                                <div class="blog__item__text">
                                    <ul>
                                        <li><i class="fa fa-calendar-o"></i>{{ date_format($blog->updated_at,"Y/m/d") }}</li>
                                        <li><i class="fa fa-comment-o"></i> </li>
                                    </ul>
                                    <h5><a href="{{ route('blog',['slug'=>$blog->slug_blog ]) }}">{{ $blog->name_blog }}</a></h5>
                                    <p>{{ $blog->short_description }} </p>
                                    <a href="{{ route('blog',['slug' => $blog->slug_blog ]) }} " class="blog__btn">Chi tiết <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="col-lg-12">
                            <div class="product__pagination blog__pagination">
                            {!! $blogs->links('pagination::bootstrap-4') !!}
                                <!-- <a href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#"><i class="fa fa-long-arrow-right"></i></a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
            $(".page-link").on("click", function(e) {
                e.preventDefault();
                var rel = $(this).text();
                var page = parseInt(rel);
                // console.log( $("select[name='category_id']").val());
                $("input[name='page']").val(page);

                $("form[name='fillter_pro']").trigger("submit");
            });
            $("#fillter_pro").on("click", function(e) {
                e.preventDefault();
                $("input[name='page']").val(1);

                $("form[name='fillter_pro']").trigger("submit");
            });
        });
</script>
@endsection
