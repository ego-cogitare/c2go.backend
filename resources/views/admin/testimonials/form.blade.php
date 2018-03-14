<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="col-md-4 control-label">{{ 'User' }}</label>
    <div class="col-md-6">
        @if (!empty($testimonial->user))
            <div style="padding-top: 7px;">{{ $testimonial->user->first_name }} {{ $testimonial->user->last_name }}</div>
        @else
            <input class="form-control" name="user_id" type="number" id="user_id" value="{{ $testimonial->user_id or ''}}" >
        @endif
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('rate') ? 'has-error' : ''}}">
    <label for="rate" class="col-md-4 control-label">{{ 'Stars' }}</label>
    <div class="col-md-6">
        <select name="rate" class="form-control" id="rate" >
    @foreach (json_decode('{"1": "1", "2": "2", "3": "3", "4": "4", "5":"5"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($testimonial->rate) && $testimonial->rate == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
        {!! $errors->first('rate', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('message') ? 'has-error' : ''}}">
    <label for="message" class="col-md-4 control-label">{{ 'Message' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" rows="5" name="message" type="textarea" id="message" >{{ $testimonial->message or ''}}</textarea>
        {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('user_agreement') ? 'has-error' : ''}}">
    <label for="user_agreement" class="col-md-4 control-label">{{ 'Show On Site Agreement' }}</label>
    <div class="col-md-6">
        <div class="radio">
    <label><input name="user_agreement" id="user_agreement" type="checkbox" value="1" {{ (isset($testimonial) && 1 == $testimonial->user_agreement) ? 'checked' : '' }}> </label>
</div>
        {!! $errors->first('user_agreement', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('site_show') ? 'has-error' : ''}}">
    <label for="site_show" class="col-md-4 control-label">{{ 'Show On Site' }}</label>
    <div class="col-md-6">
        <div class="radio">
    <label><input name="site_show" id="site_show" type="checkbox" value="1" {{ (isset($testimonial) && 1 == $testimonial->site_show) ? 'checked' : '' }}> </label>
</div>
        {!! $errors->first('site_show', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
