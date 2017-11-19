@extends('layouts.master')

@section('resources')
    <script src="{{ asset('js/custom/home/index.js') }}"></script>
@endsection

@section('content')
    <nav class="navbar navbar-default navbar-transparent navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="" class="navbar-brand" style="display: none;">
                    <img src="{{ asset('img/logo-success.png') }}" class="logo pull-left">
                    <span class="visible-xs-inline visible-sm-inline">{{ config('company.abbr') }}</span>
                    <span class="visible-md-inline visible-lg-inline">{{ config('company.name') }}</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#about-us-section">About Us</a></li>
                    <li><a href="#contact-us-section">Contact Us</a></li>
                    <li><a href="#feedbacks-section">Feedbacks</a></li>
                    <li><a href="#comments-and-suggestions-section">Comments & Suggestions</a></li>
                    @if(Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>{{ Auth::user()->user_info->first_name . ' ' . Auth::user()->user_info->last_name }}</span> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('clients.get.index') }}">Client Page</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ route('auth.get.logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('auth.get.login') }}">Login</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <header class="mastify dim">
        <div class="mastify-content">
            <div class="mastify-content-inner text-center">
                <h1 class="text-success text-shadow"><img src="{{ asset('img/logo-success.png') }}"> {{ config('company.name') }}</h1>
                <p>Start Bootstrap can help you build better websites using the Bootstrap CSS framework! Just download your template and start going, no strings attached!</p>
                <a href="{{ route('auth.get.register') }}" class="btn btn-primary btn-xl page-scroll">Register Now</a>
            </div>
        </div>
    </header>
    <section id="about-us-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <h1 class="section-heading text-center">About Us</h1>
                    <hr class="dark minimalist">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="text-center">History</h3>
                            <p class="text-faded text-justify">Backed with sales experience in the cosmetics, food and pharmaceutical ingredients, Heidi S. Panaguiton, a registered pharmacist, and current President and General Manager of Essential Ingredients Specialist Provider Inc., started trading raw materials specializing in BASF products and MM Nature’s plant liquid extracts for the cosmetic industry in 2003. The company was then Heiwin Specialties Inc.</p>
                            <p class="text-faded text-justify">By mid-2006, the company acquired exclusive distributorship of the products of Kyowa Hakko Kogyo Inc., Japan. The primary focus of the company shifted to nutraceuticals. Ms. Panaguiton decided to establish Essential Ingredients Specialist Provider that same year. The company focuses on the following concepts: Health and wellness, Sport Nutrition, Protein Fortification and Beauty Nutrition. Aimed to promote functional innovative ingredients, the company collaborates with clients by introducing concepts to suit their needs.</p>
                            <p class="text-faded text-justify">In 2007, the company becomes a corporation and continues to grow as a competitive and dynamic player in the industry.</p>
                        </div>
                        <div class="col-sm-6">
                            <h3 class="text-center">Mission</h3>
                            <p class="text-faded text-justify">The company aims to provide the customers the competitive advantage with product innovations through functional ingredients. The company believes that good products come with state-of-the art technologies. Our global principals extend their technical expertise to help our customers achieve success.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="contact-us-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <h1 class="section-heading text-center">Contact Us</h1>
                    <hr class="dark">
                    <address>
                        <strong>Essential Ingredients Specialist Provider Inc.</strong><br>
                        25D St. Therese Street, Maries Village II Phase I Antipolo City, Rizal 1870<br>
                        Tel No: (+632) 654 9807 to 09<br>
                        Telefax : (+632) 646 8115<br>
                        <a href="mailto:info@essentialingredients.ph">info@essentialingredients.ph</a>
                    </address>
                    <div class="row">
                        <div class="col-sm-6">
                            <hr class="dark">
                            <address>
                                <strong>Heidi Panaguiton-Ong</strong><br>
                                President & General Manager<br>
                                <a href="mailto:hpanaguiton@essentialingredients.ph">hpanaguiton@essentialingredients.ph</a>
                            </address>
                            <hr class="dark">
                            <address>
                                <strong>Joel Panaguiton</strong><br>
                                VP Materials and Logistics<br>
                                <a href="mailto:jpanaguiton@essentialingredients.ph">jpanaguiton@essentialingredients.ph</a>
                            </address>
                        </div>
                        <div class="col-sm-6">
                            <hr class="dark">
                            <address>
                                <strong>Gladys May "Chinkie" Tan</strong><br>
                                VP Sales & Marketing / Research & Dev't.<br>
                                <a href="mailto:ctan@essentialingredients.ph">ctan@essentialingredients.ph</a>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="feedbacks-section" class="bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="card card-success">
                        <div class="card-content">
                            <h1 class="section-heading text-center no-margin">Feedbacks</h1>
                        </div>
                    </div>
                    <h4 class="text-white text-center">Overall Client Rating.</h4>
                    <?php
                        $overallRating = 0;

                        if($feedbacks->count() > 0) {
                            foreach($feedbacks as $feedback) {
                                $overallRating += (int) $feedback->rating;
                            }

                            $overallRating = ceil($overallRating / $feedbacks->count());
                        }
                    ?>
                    <div class="rating fixed-rating size-4x" data-rate="{{ $overallRating }}">
                        <span class="star fa fa-star-o"></span>
                        <span class="star fa fa-star-o"></span>
                        <span class="star fa fa-star-o"></span>
                        <span class="star fa fa-star-o"></span>
                        <span class="star fa fa-star-o"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="comments-and-suggestions-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <h1 class="section-heading text-center">Comments & Suggestions</h1>
                    <hr class="dark">
                    <!-- TODO: Display comments -->
                    <div style="overflow-y: scroll; margin-bottom 10px; max-height: 400px;">
                        @foreach($feedbacks as $feedback)
                            <blockquote>
                                <p>{{ $feedback->comment }}</p>
                                <footer>{{ $feedback->account->user_info->first_name . ' ' . $feedback->account->user_info->last_name }} - {{ $feedback->account->role }}</footer>
                            </blockquote>
                        @endforeach
                    </div>
                    @if(Auth::check())
                        <div class="well">
                            @include('partials.flash')
                            <form action="{{ route('home.post.create_feedbacks') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                            <label for="comment-field">Comment:</label>
                                            <input type="text" name="comment" id="comment-field" class="form-control" value="{{ old('comment') }}" placeholder="Comment" required>
                                            @if ($errors->has('comment'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('comment') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group{{ $errors->has('rate') ? ' has-error' : '' }}">
                                            <label for="rate-field">Rate:</label>
                                            <select name="rate" class="form-control" id="rate-field" required>
                                                <option value="" selected disabled>Select an option...</option>
                                                <option value="1"{{ (old('rate') === '1' ? ' selected' : '') }}>1 Star</option>
                                                <option value="2"{{ (old('rate') === '2' ? ' selected' : '') }}>2 Stars</option>
                                                <option value="3"{{ (old('rate') === '3' ? ' selected' : '') }}>3 Stars</option>
                                                <option value="4"{{ (old('rate') === '4' ? ' selected' : '') }}>4 Stars</option>
                                                <option value="5"{{ (old('rate') === '5' ? ' selected' : '') }}>5 Stars</option>
                                            </select>
                                            @if ($errors->has('rate'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('rate') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-primary" type="submit"><span class="fa fa-send fa-fw"></span> Send</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="text-center">© Copyright {{ date('Y') }} All rights reserved.</div>
    </footer>
@endsection
