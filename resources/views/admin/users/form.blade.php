<div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
    <label for="first_name" class="col-md-4 control-label">{{ 'First Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="first_name" type="text" id="first_name" value="{{ $user->first_name or ''}}" >
        {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
    <label for="last_name" class="col-md-4 control-label">{{ 'Last Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="last_name" type="text" id="last_name" value="{{ $user->last_name or ''}}" >
        {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="col-md-4 control-label">{{ 'Email' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="email" type="text" id="email" value="{{ $user->email or ''}}" >
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    <label for="password" class="col-md-4 control-label">{{ 'Password' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="password" type="password" id="password" value="{{ $user->password or ''}}" >
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('password2') ? 'has-error' : ''}}">
    <label for="password2" class="col-md-4 control-label">{{ 'Repeat Password' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="password2" type="password" id="password2" value="{{ $user->password2 or ''}}" >
        {!! $errors->first('password2', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('is_blocked') ? 'has-error' : ''}}">
    <label for="is_blocked" class="col-md-4 control-label">{{ 'Is Blocked' }}</label>
    <div class="col-md-6">
        <div class="radio">
    <label><input name="is_blocked" id="is_blocked" type="checkbox" value="1" {{ (isset($user) && 1 == $user->is_blocked) ? 'checked' : '' }}> </label>
</div>
        {!! $errors->first('is_blocked', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<!--<div class="form-group {{ $errors->has('avatar') ? 'has-error' : ''}}">
    <label for="avatar" class="col-md-4 control-label">{{ 'Avatar' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="avatar" type="file" id="avatar" value="{{ $user->avatar or ''}}" >
        {!! $errors->first('avatar', '<p class="help-block">:message</p>') !!}
    </div>
</div>-->
<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
