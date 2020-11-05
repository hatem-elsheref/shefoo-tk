@extends('backend.layouts.master')

@section('content')
    <nav aria-label="breadcrumb" class="paths-nav">
        <ol class="breadcrumb breadcrumb-inverse">
            <li class="breadcrumb-item">
                <a href="{{route('dashboard.index')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('setting.index')}}">Settings</a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">Translation</li>
        </ol>
    </nav>
    @foreach($errors->all() as $error)
        <pre><code>{{$error}}</code></pre>
    @endforeach
    <form method="post" action="{{route('translation.save')}}">
        @csrf
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                    <h2>{{__('backend.manage_translation_keys')}}</h2>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="key">{{__('backend.translation_key')}}</label>
                                    <input type="text" class="form-control" name="newKey" value="{{old('newKey')}}">
                                </div>
                            </div>
                        </div>

                        @foreach($locales as $localeCode => $properties)
                            <h6 class="badge badge-danger font-weight-bold mb-2">{{__('backend.translation_value_of')}} {{$properties['name']}}</h6>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input id="value-{{$localeCode}}" type="text" class="form-control" name="newValue[{{$localeCode}}]" value="{{old('newValue')[$localeCode] ?? ''    }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group">
                            <label for="translationFile">{{__('backend.translation_file')}}</label>
                            <select class="form-control" name="translationFile" id="translationFile">
                                <option selected disabled>{{__('backend.choice_file')}}</option>
                                @foreach($locales as $localeCode => $properties)
                                    @foreach($data[$localeCode] as $fileName => $keys)
                                        <option value="{{$fileName}}" @if(old('translationFile') == $fileName) selected  @endif>{{$fileName}}</option>
                                    @endforeach
                                    @break
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary btn-default">{{__('backend.save')}}</button>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-default">
                <div class="card-header">
                    <ul class="nav nav-tabs nav-style-border pl-0 justify-content-between justify-content-xl-start" id="myTab" role="tablist">
                        @foreach($locales as $localeCode => $properties)
                            <li class="nav-item">
                                <a class="nav-link @if($loop->first) active @endif" id="{{$localeCode}}-tab" data-toggle="tab" href="#{{$localeCode}}-{{$properties['name']}}" role="tab" aria-controls="{{$localeCode}}-{{$properties['name']}}" aria-selected="false">{{$properties['name']}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                    <div class="card-body" style="padding:5px 50px">
                        <div class="tab-content" id="myTabContent3">
                            @foreach($locales as $localeCode => $properties)
                                <div class="tab-pane pt-3 fade @if($loop->first) show active @endif" id="{{$localeCode}}-{{$properties['name']}}" role="tabpanel" aria-labelledby="{{$localeCode}}-tab">
                                    <div class="row">
                                     @foreach($data[$localeCode] as $fileName => $keys)
                                         <div class="col-sm-12">
                                             <h6 class="badge badge-success"><i class="mdi mdi-file"></i> {{$fileName}} {{__('backend.file')}}</h6>
                                         </div>
                                            @foreach($keys as $key => $value)
                                                <div class="col-sm-6" id="{{$fileName}}-{{$localeCode}}-{{$key}}-key">
                                                    <div class="form-group">
                                                        <label for="{{$fileName}}-{{$localeCode}}-{{$key}}">{{$key}} <i class="mdi mdi-trash-can-outline text-danger" onclick="removeInput('{{$fileName}}-{{$localeCode}}-{{$key}}-key')"></i></label>
                                                        <input id="{{$fileName}}-{{$localeCode}}-{{$key}}" type="text" class="form-control" name="{{$fileName}}[{{$localeCode}}][{{$key}}]" value="{{$value}}">
                                                    </div>
                                                </div>
                                            @endforeach
                                     @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </form>
@endsection
@section('js')
    <script>
        function removeInput(group_id){
            console.log(group_id);
            $('#'+group_id).remove();
        }
    </script>
@endsection
