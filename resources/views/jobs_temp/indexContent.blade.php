<div class="page">
    <div class="container">
        <!-- category ad -->

        <div class="section job-list-item">
            <div class="section-title tab-manu">
                <h4>Вакансии партнеров академии "МАЙ"</h4>
            </div>

            <div class="tab-content">
                @if(!empty($jobs) and count($jobs) >= 1)
                <div role="tabpanel" class="tab-pane fade in active">
                    @foreach($jobs as $job)

                    <div class="job-ad-item">
                        <div class="item-info">
                            <div class="item-image-box">
                                <div class="item-image">
                                    <a href="{{route('jobs.readmore',$job->id)}}"><img src="{{(!empty($job->info->logo)) ? asset(env('THEME')).'/images/partners/logo/'.$job->info->logo : asset(env('THEME_JOBS')).'/images/job/no-logo.png' }}" alt="{{$job->job_title}}" class="img-responsive"></a>
                                </div><!-- item-image -->
                            </div>

                            <div class="ad-info">
                                <span><a href="{{route('jobs.readmore',$job->id)}}" class="title">{{$job->job_title}}</a> @ <a href="#">{{$job->info->company_name}}</a></span>
                                <div class="ad-meta">
                                    <ul>
                                        @if(!empty($job->address))
                                        <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i>{{$job->address}}</a></li>
                                        @endif
                                        <li><a href="#"><i class="fa fa-money" aria-hidden="true"></i>{{$job->salary}}</a></li>
                                        <li><a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i>{{$job->working_schedule}}</a></li>
                                    </ul>
                                </div><!-- ad-meta -->
                            </div><!-- ad-info -->
                            <div class="button">
                                <a href="{{route('jobs.readmore',$job->id)}}" class="btn btn-primary">Подробнее</a>
                            </div>
                        </div><!-- item-info -->
                    </div><!-- ad-item -->
                    @endforeach

                </div>
                    <div class="text-center">
                        <ul class="pagination">
                            @if($jobs->currentPage() !== 1)
                            <li>
                                <a href="{{$jobs->url($jobs->currentPage() - 1)}}">
                                    <i class="fa fa-chevron-left"></i>
                                </a>
                            </li>
                            @endif
                            @for($i = 1; $i <= $jobs->lastPage(); $i++)
                                @if($jobs->currentPage() == $i)
                                    <li href="{{$jobs->url($i) }}" class="active">
                                        <a href="#">{{$i}}</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{$jobs->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor
                            @if($jobs->currentPage() !== $jobs->lastPage())
                                <li><a href="{{$jobs->url($jobs->currentPage() + 1)}}"><i class="fa fa-chevron-right"></i></a></li>
                            @endif
                        </ul>
                    </div><!-- pagination  -->

            </div><!-- tab-pane -->
            @else
                <div class="alert alert-info">
                   <p>Нет вакансий!</p>
                    </div>
            @endif

            </div><!-- tab-content -->
        </div><!-- trending ads -->
    </div><!-- conainer -->
</div><!-- page -->