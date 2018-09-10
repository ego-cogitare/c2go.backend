<style>
    .timepicker-sbs {
        display: block;
    }
</style>
<div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
    <label for="category_id" class="col-md-4 control-label">{{ 'Category' }}</label>
    <div class="col-md-6">
        <select name="category_id" class="form-control" id="category_id">
            <option value="">-Category-</option>
            @foreach ($categories as $category)
                @if (sizeof($category->categories) > 0)
                <optgroup label="{{ $category->name }}">
                    @foreach ($category->categories as $subcategory)
                        <option value="{{ $subcategory->id }}" {{ (isset($event->category_id) && $event->category_id == $subcategory->id) ? 'selected' : ''}}>{{ $subcategory->name }}</option>
                    @endforeach
                </optgroup>
                @else
                    <option value="{{ $category->id }}" {{ (isset($event->category_id) && $event->category_id == $category->id) ? 'selected' : ''}}>{{ $category->name }}</option>
                @endif
            @endforeach
        </select>
        {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="col-md-4 control-label">{{ 'Creator' }}</label>
    <div class="col-md-6">
        <select name="user_id" class="form-control" id="user_id" >
            <option value="">-Creator user-</option>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ (isset($event->user_id) && $event->user_id == $user->id) ? 'selected' : ''}}>{{ $user->getFullName() }}</option>
            @endforeach
        </select>
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $event->name ?? old('name') ?? ''}}" >
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="col-md-4 control-label">{{ 'Description' }}</label>
    <div class="col-md-6">
        <textarea class="form-control" name="description" id="description">{{ $event->description ?? old('description') ?? ''}}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('event_location_human') ? 'has-error' : ''}}">
    <label for="event_location_human" class="col-md-4 control-label">{{ 'Event Location' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="event_location_human" type="text" id="event_location_human" value="{{ $event->event_location_human ?? old('event_location_human') ?? ''}}" >
        <input name="event_location_latlng" type="hidden" id="event_location_latlng" value="{{ $event->event_location_latlng ?? old('event_location_latlng') ?? ''}}" >
        {!! $errors->first('event_location_human', '<p class="help-block">:message</p>') !!}
    </div>
</div><div class="form-group {{ $errors->has('event_destination_human') ? 'has-error' : ''}}">
    <label for="event_destination_human" class="col-md-4 control-label">{{ 'Event Destination' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="event_destination_human" type="text" id="event_destination_human" value="{{ $event->event_destination_human ?? old('event_destination_human') ?? ''}}" >
        {!! $errors->first('event_destination_human', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('date') ? 'has-error' : ''}}">
    <label for="date" class="col-md-4 control-label">{{ 'Date' }}</label>
    <div class="col-md-6 input-group date" style="padding:0 15px">
        <input class="form-control datetime-picker" name="date" type="text" id="date" value="{{ $event->date ?? old('date') ?? ''}}" >
        {!! $errors->first('date', '<p class="help-block">:message</p>') !!}
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>
<div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
    <label for="price" class="col-md-4 control-label">{{ 'Price' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="price" type="text" id="price" value="{{ $event->price ?? old('price') ?? ''}}" >
        {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('is_active') ? 'has-error' : ''}}">
    <label for="is_active" class="col-md-4 control-label">{{ 'Is Active' }}</label>
    <div class="col-md-6">
        <div class="radio">
            <label><input name="is_active" type="radio" value="1" {{ (isset($event) && 1 == $event->is_active || !isset($event)) ? 'checked' : '' }}> Yes</label>
        </div>
        <div class="radio">
            <label><input name="is_active" type="radio" value="0" @if (isset($event)) {{ (0 == $event->is_active) ? 'checked' : '' }} @endif> No</label>
        </div>
        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
