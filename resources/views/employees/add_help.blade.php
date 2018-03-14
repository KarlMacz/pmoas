@extends('layouts.employees')

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Help</h1>
        <div>Add Frequently Asked Questions (FAQ)</div>
    </div>
    <div class="container-spacious">
        <div class="form-group">
            <a href="{{ route('employees.get.help') }}" class="btn btn-primary"><span class="fa fa-arrow-left fa-fw"></span> Go Back</a>
        </div>
        @include('partials.flash')
        <form action="{{ route('employees.post.help_add') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                <label for="question-field">Question:</label>
                <input type="text" name="question" id="question-field" class="form-control" value="{{ old('question') }}" placeholder="Question" required autofocus>
                @if ($errors->has('question'))
                    <span class="help-block">
                        <strong>{{ $errors->first('question') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                <label for="answer-field">Answer:</label>
                <input type="text" name="answer" id="answer-field" class="form-control" value="{{ old('answer') }}" placeholder="Answer" required>
                @if ($errors->has('answer'))
                    <span class="help-block">
                        <strong>{{ $errors->first('answer') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                <label for="type-field">Type:</label>
                <select name="type" id="type-field" class="form-control" required>
                    <option value="" selected disabled>Select an option...</option>
                    <option value="Clients">Clients</option>
                    <option value="Employees">Employees</option>
                </select>
                @if ($errors->has('type'))
                    <span class="help-block">
                        <strong>{{ $errors->first('type') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success" type="submit"><span class="fa fa-plus fa-fw"></span> Add</button>
            </div>
        </form>
    </div>
@endsection
