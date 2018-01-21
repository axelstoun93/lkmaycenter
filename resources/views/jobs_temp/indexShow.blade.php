<section class="job-bg page job-details-page">
    <div class="container">




        <div class="job-details">
            <div class="section job-ad-item">
                <div class="item-info">
                    <div class="item-image-box">
                        <div class="item-image">
                            <img src="{{(!empty($job->info->logo)) ? asset(env('THEME')).'/images/partners/logo/'.$job->info->logo : asset(env('THEME_JOBS')).'/images/job/no-logo.png' }}" alt="{{$job->job_title}}" class="img-responsive">
                        </div><!-- item-image -->
                    </div>

                    <div class="ad-info">
                        <span><span><a href="#" class="title">{{$job->job_title}}</a></span> @ <a href="#"> {{$job->info->company_name}}</a></span>
                        <div class="ad-meta">
                            <ul>
                                @if(!empty($job->address))
                                    <li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i>{{$job->address}}</a></li>
                                @endif
                                <li><i class="fa fa-money" aria-hidden="true"></i>{{$job->salary}}</li>
                                <li><a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i>{{$job->working_schedule}}</a></li>
                            </ul>
                        </div><!-- ad-meta -->
                    </div><!-- ad-info -->
                </div><!-- item-info -->

            </div><!-- job-ad-item -->

            <div class="job-details-info">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="section job-description">
                            <div class="description-info">
                                <h1>Обязанности:</h1>
                                {!! $job->duties !!}
                            </div>
                            <div class="responsibilities">
                                <h1>Требования:</h1>
                                {!! $job->demand !!}
                            </div>
                            <div class="responsibilities">
                                <h1>Опыт работы:</h1>
                                {!! $job->work_experience !!}
                            </div>
                            <div class="requirements">
                                <h1>Условия работы:</h1>
                                {!! $job->condition !!}
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-4">
                        <div class="section company-info">
                            <h1>Информация о работодателе:</h1>
                            <ul>
                                <li>Название: <a href="#">{{$job->info->company_name}}</a></li>
                                <li>Телефон: {{$job->info->phone}}</li>
                                <li>Email: <a href="#">{{$job->user->email}}</a></li>
                                <li>Сайт: <a href="">{{$job->info->site}}</a></li>
                            </ul>
                        </div>
                    </div>

                </div><!-- row -->
                <div class="section">
                <div class="button text-center">
                    <a href="{{URL::previous()}}" class="btn btn-primary">Вернуться назад</a>
                </div>
                </div>
            </div><!-- job-details-info -->

        </div><!-- job-details -->
    </div><!-- container -->
</section><!-- job-details-page -->