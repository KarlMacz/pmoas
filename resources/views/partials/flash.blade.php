@if(session()->has('flash_status'))
    @if(session()->get('flash_status') === 'Success')
        <div class="alert alert-success">{{ session()->get('flash_message') }}</div>
    @elseif(session()->get('flash_status') === 'Failed')
        <div class="alert alert-danger">{{ session()->get('flash_message') }}</div>
    @else
        <div class="alert alert-info">{{ session()->get('flash_message') }}</div>
    @endif
@endif
