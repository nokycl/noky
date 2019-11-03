<div class="row">
    @foreach($project->files as $file)
        <div class="col-md-2 m-b-10">
            <div class="card">
                @if(config('filesystems.default') == 'local')
                    <div class="file-bg">
                        <div class="overlay-file-box">
                            <div class="user-content">
                                @if($file->icon == 'images')
                                    <img class="card-img-top img-responsive" src="{{ asset('user-uploads/project-files/'.$project->id.'/'.$file->hashname) }}" alt="Card image cap">
                                @else
                                    <i class="fa {{$file->icon}}" style="font-size: -webkit-xxx-large; padding-top: 65px;"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif(config('filesystems.default') == 's3')
                    <div class="file-bg">
                        <div class="overlay-file-box">
                            <div class="user-content">
                                @if($file->icon == 'images')
                                    <img class="card-img-top img-responsive" src="{{ $url.'project-files/'.$project->id.'/'.$file->filename }}" alt="Card image cap">
                                @else
                                    <i class="fa {{$file->icon}}" style="font-size: -webkit-xxx-large; padding-top: 65px;"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif(config('filesystems.default') == 'google')
                    <div class="file-bg">
                        <div class="overlay-file-box">
                            <div class="user-content">
                                @if($file->icon == 'images')
                                    <img class="card-img-top img-responsive" src="{{ $file->google_url }}" alt="Card image cap">
                                @else
                                    <i class="fa {{$file->icon}}" style="font-size: -webkit-xxx-large; padding-top: 65px;"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif(config('filesystems.default') == 'dropbox')
                    <div class="file-bg">
                        <div class="overlay-file-box">
                            <div class="user-content">
                                @if($file->icon == 'images')
                                    <img class="card-img-top img-responsive" src="{{ $file->dropbox_link }}" alt="Card image cap">
                                @else
                                    <i class="fa {{$file->icon}}" style="font-size: -webkit-xxx-large; padding-top: 65px;"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card-block">
                    <h6 class="card-title">{{ $file->filename }}</h6>
                    @if($file->external_link != '')
                        <a target="_blank" href="{{ $file->external_link }}"
                                                                            data-toggle="tooltip" data-original-title="View"
                                                                            class="btn btn-info btn-circle"><i
                                                                                     class="fa fa-search"></i></a>
                    @elseif(config('filesystems.default') == 'local')
                        <a target="_blank" href="{{ asset('user-uploads/project-files/'.$project->id.'/'.$file->hashname) }}"
                           data-toggle="tooltip" data-original-title="View"
                           class="btn btn-info btn-circle"><i
                                    class="fa fa-search"></i></a>
                    @elseif(config('filesystems.default') == 's3')
                        <a target="_blank" href="{{ $url.'project-files/'.$project->id.'/'.$file->filename }}"
                           data-toggle="tooltip" data-original-title="View"
                           class="btn btn-info btn-circle"><i
                                    class="fa fa-search"></i></a>
                    @elseif(config('filesystems.default') == 'google')
                        <a target="_blank" href="{{ $file->google_url }}"
                           data-toggle="tooltip" data-original-title="View"
                           class="btn btn-info btn-circle"><i
                                    class="fa fa-search"></i></a>
                    @elseif(config('filesystems.default') == 'dropbox')
                        <a target="_blank" href="{{ $file->dropbox_link }}"
                           data-toggle="tooltip" data-original-title="View"
                           class="btn btn-info btn-circle"><i
                                    class="fa fa-search"></i></a>
                    @endif
                    @if(is_null($file->external_link))
                    <a href="{{ route('client.files.download', $file->id) }}"
                       data-toggle="tooltip" data-original-title="Download"
                       class="btn btn-inverse btn-circle"><i
                                class="fa fa-download"></i></a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>