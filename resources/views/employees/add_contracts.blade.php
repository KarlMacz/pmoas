@extends('layouts.employees')

@section('resources')
    <script src="{{ asset('js/custom/employees/add_contracts.js') }}"></script>
@endsection

@section('content')
    <div class="page-header">
        <h1 class="no-margin">Contract Management</h1>
        <div>Contract Creation</div>
    </div>
    <div class="container-spacious">
        @include('partials.flash')
        <form action="{{ route('employees.post.contracts_add') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="contractor-field">Contractor:</label>
                        <input type="text" id="contractor-field" class="form-control" value="{{ Auth::user()->user_info->first_name . ' ' . Auth::user()->user_info->last_name }}" placeholder="Contractor" readonly>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('client') ? ' has-error' : '' }}">
                        <label for="client-field">Client:</label>
                        <select name="client" id="client-field" class="form-control" required autofocus>
                            <option value="" selected disabled>Select an option...</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->user_info->first_name . ' ' . $client->user_info->last_name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('client'))
                            <span class="help-block">
                                <strong>{{ $errors->first('client') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('lifespan_start') ? ' has-error' : '' }}">
                        <label for="lifespan-start-field">Lifespan Start:</label>
                        <input type="date" name="lifespan_start" id="lifespan-start-field" class="form-control" placeholder="Lifespan Start" required>
                        @if ($errors->has('lifespan_start'))
                            <span class="help-block">
                                <strong>{{ $errors->first('lifespan_start') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('lifespan_end') ? ' has-error' : '' }}">
                        <label for="lifespan-end-field">Lifespan End:</label>
                        <input type="date" name="lifespan_end" id="lifespan-end-field" class="form-control" placeholder="Lifespan End" required>
                        @if ($errors->has('lifespan_end'))
                            <span class="help-block">
                                <strong>{{ $errors->first('lifespan_end') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                        <label for="type-field">Contract Type:</label>
                        <select name="type" id="type-field" class="form-control" required autofocus>
                            <option value="" selected disabled>Select an option...</option>
                            <option value="Solo">Solo</option>
                            <option value="Special">Special</option>
                        </select>
                        @if ($errors->has('type'))
                            <span class="help-block">
                                <strong>{{ $errors->first('type') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group{{ $errors->has('structure') ? ' has-error' : '' }}">
                        <label for="structure-field">Contract Structure:</label>
                        <textarea name="structure" id="structure-field" cols="30" rows="10" maxlength="1000" class="form-control" maxlength="1000" placeholder="Contract Structure" style="resize: none;" required></textarea>
                        @if ($errors->has('structure'))
                            <span class="help-block">
                                <strong>{{ $errors->first('structure') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('maximum_amount') ? ' has-error' : '' }}">
                        <label for="maximum-amount-field">Maximum Amount:</label>
                        <input type="number" name="maximum_amount" id="maximum-amount-field" class="form-control" placeholder="Maximum Amount" required>
                        @if ($errors->has('maximum_amount'))
                            <span class="help-block">
                                <strong>{{ $errors->first('maximum_amount') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('holdback_amount') ? ' has-error' : '' }}">
                        <label for="holdback-amount-field">Holdback Amount:</label>
                        <input type="number" name="holdback_amount" id="holdback-amount-field" class="form-control" placeholder="Holdback Amount" required>
                        @if ($errors->has('holdback_amount'))
                            <span class="help-block">
                                <strong>{{ $errors->first('holdback_amount') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group{{ $errors->has('payment_mode') ? ' has-error' : '' }}">
                        <label for="payment-mode-field">Mode of Payment:</label>
                        <select name="payment_mode" id="payment-mode-field" class="form-control" required>
                            <option value="" selected disabled>Select an option...</option>
                            <option value="Cash on Delivery">Cash on Delivery</option>
                            <option value="PayPal">PayPal</option>
                        </select>
                        @if ($errors->has('payment_mode'))
                            <span class="help-block">
                                <strong>{{ $errors->first('payment_mode') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="well lighten">
                <div style="margin-bottom: 10px;">
                    <button type="button" class="add-rule-button btn btn-primary btn-sm"><span class="fa fa-plus fa-fw"></span> Add Rule / Prohibition</button>
                </div>
                <div id="rules-fieldset">
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon">Rule / Prohibition:</label>
                            <input type="text" name="rules[]" class="form-control" placeholder="Rule / Prohibition" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success" type="submit"><span class="fa fa-plus fa-fw"></span> Add</button>
            </div>
        </form>
    </div>
@endsection
