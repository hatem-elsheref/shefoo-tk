@extends('backend.layouts.master')
@section('content')
    <nav aria-label="breadcrumb" class="paths-nav">
        <ol class="breadcrumb breadcrumb-inverse">
            <li class="breadcrumb-item">
                <a href="{{route('dashboard.index')}}">{{__('backend.home')}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('Post.index')}}">{{__('backend.posts')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{__('backend.create_post')}}</li>
        </ol>
    </nav>
    <div class="card card-default mt-2">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2>{{__('backend.create_new_post')}}</h2>
            <a href="{{route('Post.index')}}" title="{{__('backend.show_all_posts')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-backup-restore"></i></a>
        </div>
        <div class="card-body">
            <form method="post" id="d" action="{{route('Post.store')}}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="title">{{__('backend.post_title')}}</label>
                            <input type="text" class="form-control" name="title" placeholder="{{__('backend.enter')}} {{__('backend.post_title')}}" value="{{old('title')}}">
                            @error('title')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="category">{{__('backend.category')}}</label>
                            <select name="category" class="form-control">
                                <option selected disabled> {{__('backend.select_option')}}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category') == $category->id) selected @endif>{{ ucwords($category->name) }}</option>
                                @endforeach
                            </select>
                            @error('category')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="status">{{__('backend.status')}}</label>
                            <select name="status" class="form-control">
                                <option selected disabled> {{__('backend.select_option')}}</option>
                                <option value="published" @if(old('status') == 'published') selected @endif>Published</option>
                                <option value="drafted" @if(old('status') == 'drafted') selected @endif>Drafted</option>
                            </select>
                            @error('status')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="status">{{__('backend.meta_tags')}}</label>
                            <select class="post-meta-tags form-control" name="meta[]" multiple="multiple"></select>
                            @error('meta')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="coverImage">{{__('backend.post_image')}}</label>
                            <div class="custom-file mb-1">
                                <input type="file" class="custom-file-input" name="image" id="coverImage" >
                                <label class="custom-file-label" for="coverImage">{{__('backend.choice_file')}}</label>
                            </div>
                            @error('image')
                            <span class="text-danger">{{$message}}</span><br>
                            @enderror
                            <img style="width: 60px;height:60px" id="img-preview" class="mt-2 img-responsive  img-fluid" src="{{ uploads(mainPath(_BLOG.'/'.DEFAULT_IMAGE)) }}">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tags">{{__('backend.tags')}}</label>
                            <select class="post-tags form-control" name="tags[]" multiple="multiple">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}" @if(in_array($tag->id,(array) old('tags'))) selected @endif>{{ ucwords($tag->name) }}</option>
                                @endforeach
                            </select>
                            @error('tags')
                            <span class="text-danger">{{$message}}</span><br>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="editor">{{__('backend.post_content')}}</label>
                            <textarea name="content" id="editor" class="form-control" style="height: 500px">{!! old('content') !!}</textarea>
                            @error('content')
                            <span class="text-danger">{{$message}}</span><br>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="form-footer pt-5 border-top">
                    <button type="submit" class="btn btn-primary btn-default">{{__('backend.save')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    <script src='https://cloud.tinymce.com/stable/tinymce.min.js'></script>
{{--    <script src="https://cdn.tiny.cloud/1/4b2rd40qpdelgfmi3oofgocpnxs28fndbr734f0c12ctqmk0/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>--}}
    <script>
        /*======== 4. MULTIPLE SELECT ========*/
        $(".post-meta-tags").select2({tags: true});
        $(".post-tags").select2({tags: false});

        // Editor
        var editor_config = {
            selector: '#editor',
            toolbar_mode: 'floating',
            path_absolute :  "{{route('unisharp.lfm.show')}}",
            convert_urls: true,
            height:400,
            statusbar: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "forecolor backcolor code insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
                var cmsURL = editor_config.path_absolute +'?field_name=' + field_name;
                if (type === 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.open({
                    file : cmsURL,
                    title : 'File Manager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no"
                });}};

        window.onload = function (){
            tinymce.init(editor_config);
        }



    </script>

@endsection
