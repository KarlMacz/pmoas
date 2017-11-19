@extends('layouts.master')

@section('content')
    <div id="homepage-header" class="casket">
        <div class="casket-content" style="width: 700px;">
            <div class="text-left" style="margin-bottom: 10px;">
                <a href="{{ route('auth.get.login') }}" class="btn btn-primary btn-sm"><span class="fa fa-arrow-left fa-fw"></span> Go Back</a>
            </div>
            <div class="card card-success">
                <div class="card-header">Register</div>
            </div>
            <div class="card">
                <div class="card-content">
                    @include('partials.flash')
                    <form action="{{ route('auth.post.register') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                    <label for="username-field">Username:</label>
                                    <input type="text" name="username" id="username-field" class="form-control" value="{{ old('username') }}" placeholder="Username" required autofocus>
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email-field">E-mail Address:</label>
                                    <input type="email" name="email" id="email-field" class="form-control" value="{{ old('email') }}" placeholder="E-mail Address" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password-field">Password:</label>
                                    <input type="password" name="password" id="password-field" class="form-control" placeholder="Password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="confirm-password-field">Confirm Password:</label>
                                    <input type="password" name="password_confirmation" id="confirm-password-field" class="form-control" placeholder="Confirm Password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label for="first-name-field">First Name:</label>
                                    <input type="text" name="first_name" id="first-name-field" class="form-control" value="{{ old('first_name') }}" placeholder="First Name" required>
                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('middle_name') ? ' has-error' : '' }}">
                                    <label for="middle-name-field">Middle Name:</label>
                                    <input type="text" name="middle_name" id="middle-name-field" class="form-control" value="{{ old('middle_name') }}" placeholder="Middle Name">
                                    @if ($errors->has('middle_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('middle_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="last-name-field">Last Name:</label>
                                    <input type="text" name="last_name" id="last-name-field" class="form-control" value="{{ old('last_name') }}" placeholder="Last Name" required>
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label for="address-field">Address:</label>
                                    <input type="text" name="address" id="address-field" class="form-control" value="{{ old('address') }}" placeholder="Address" required>
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group{{ $errors->has('contact_number') ? ' has-error' : '' }}">
                                    <label for="contact-number-field">Contact Number:</label>
                                    <input type="text" name="contact_number" id="contact-number-field" class="form-control" value="{{ old('contact_number') }}" placeholder="Contact Number" required>
                                    @if ($errors->has('contact_number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('contact_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('birth_date') ? ' has-error' : '' }}">
                                    <label for="birth-date-field">Birth Date:</label>
                                    <input type="date" name="birth_date" id="birth-date-field" class="form-control" value="{{ old('birth_date') }}" placeholder="Birth Date" required>
                                    @if ($errors->has('birth_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('birth_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                    <label for="gender-field">Gender:</label>
                                    <select name="gender" class="form-control" id="gender-field" required>
                                        <option value="" selected disabled>Select an option...</option>
                                        <option value="Male"{{ (old('gender') === 'Male' ? ' selected' : '') }}>Male</option>
                                        <option value="Female"{{ (old('gender') === 'Female' ? ' selected' : '') }}>Female</option>
                                    </select>
                                    @if ($errors->has('gender'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('secret_question') ? ' has-error' : '' }}">
                                    <label for="secret-question-field">Secret Question:</label>
                                    <select name="secret_question" class="form-control" id="secret-question-field" required>
                                        <option value="" selected disabled>Select an option...</option>
                                        <option value="What is your favorite object?">What is your favorite object?</option>
                                        <option value="What is your pet's name?">What is your pet's name?</option>
                                        <option value="First thing you do after eating a meal?">First thing you do after eating a meal?</option>
                                    </select>
                                    @if ($errors->has('secret_question'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('secret_question') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group{{ $errors->has('secret_answer') ? ' has-error' : '' }}">
                                    <label for="secret-answer-field">Secret Answer:</label>
                                    <input type="text" name="secret_answer" id="secret-answer-field" class="form-control" placeholder="Secret Answer" required>
                                    @if ($errors->has('secret_answer'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('secret_answer') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="well" style="overflow-y: scroll; max-height: 200px;">
                                <h3 class="no-margin text-center">Terms & Conditions</h3>
                                <br>
                                <p>This is a sample terms & condition. Replace this with a valid terms & conditions.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic earum veniam cumque necessitatibus molestias atque facilis omnis asperiores alias itaque dolore labore, dolores perspiciatis, laborum unde. Commodi enim et expedita.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos veritatis eum laborum itaque voluptas earum ad ea in dolorem cupiditate esse, reiciendis suscipit voluptate sit impedit commodi possimus, soluta eius.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque reprehenderit earum animi ullam. Consequuntur est voluptate, dolorem, ducimus mollitia fugiat cupiditate sit ratione, consectetur illo harum ipsum doloremque inventore repellat.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas nisi quaerat aliquid pariatur doloribus nulla illum animi, molestias dignissimos sapiente inventore quo aperiam quam in incidunt expedita perspiciatis laboriosam suscipit.</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae, nobis? Mollitia perferendis facilis tempore harum eum, recusandae eius veritatis nesciunt quasi aut esse tenetur veniam velit, dolorum aspernatur incidunt! Deserunt.</p>
                            </div>
                            <div class="checkbox text-center">
                                <label>
                                    <strong><input type="checkbox" name="agreement" required> I Agree to the Terms & Conditions.</strong>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITEKEY') }}"></div>
                            @if($errors->has('g-recaptcha-response'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-success" type="submit"><span class="fa fa-plus fa-fw"></span> Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
