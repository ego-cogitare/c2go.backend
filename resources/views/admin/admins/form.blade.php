<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $admin->name or ''}}" >
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="col-md-4 control-label">{{ 'Email' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="email" type="text" id="email" value="{{ $admin->email or ''}}" >
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    <label for="password" class="col-md-4 control-label">{{ 'Password' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="password" type="password" id="password" value="{{ $admin->password or ''}}" >
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('password2') ? 'has-error' : ''}}">
    <label for="password" class="col-md-4 control-label">{{ 'Repeat Password' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="password2" type="password" id="password" value="{{ $admin->password2 or ''}}" >
        {!! $errors->first('password2', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<!--<div class="form-group {{ $errors->has('deleted_at') ? 'has-error' : ''}}">
    <label for="deleted_at" class="col-md-4 control-label">{{ 'Deleted At' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="deleted_at" type="datetime-local" id="deleted_at" value="{{ $admin->deleted_at or ''}}" >
        {!! $errors->first('deleted_at', '<p class="help-block">:message</p>') !!}
    </div>
</div>-->

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
