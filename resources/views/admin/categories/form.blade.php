<style>
    .type-color {
        padding: 0;
        width: 32px;
        margin: 0;
        background: none;
        border: none;
        height: 36px;
    }
    .cover-photo {
        max-width: 64px;
        min-width: 64px;
        max-height: 64px;
        min-height: 64px;
        object-fit: cover;
    }
</style>

@if (empty($category) || !empty($category->parent_id))
<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : ''}}">
    <label for="parent_id" class="col-md-4 control-label">{{ 'Parent Category' }}</label>
    <div class="col-md-6">
        <select name="parent_id" class="form-control" id="parent_id" >
            <option value="">-Parent category-</option>
            @foreach ($categories as $item)
                <option value="{{ $item->id }}" {{ (isset($category) && $item->id == $category->parent_id) ? 'selected' : ''}}>{{ $item->name }}</option>
            @endforeach
        </select>
        {!! $errors->first('parent_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif
<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="col-md-4 control-label">{{ 'Name' }}</label>
    <div class="col-md-6">
        <input class="form-control" name="name" type="text" id="name" value="{{ $category->name or ''}}" >
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('color') ? 'has-error' : ''}}">
    <label for="color" class="col-md-4 control-label">{{ 'Color' }}</label>
    <div class="col-md-6 input-group color-picker" style="padding:0 15px">
        <input class="form-control" name="color" type="text" id="color" value="{{ $category->color or ''}}" />
        <div class="input-group-addon">
            <i></i>
        </div>
        {!! $errors->first('color', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('cover_photo') ? 'has-error' : ''}}">
    <label for="cover_photo" class="col-md-4 control-label">{{ 'Cover Photo' }}</label>
    <div class="col-md-6">
        @if (!empty($category->cover_photo)) <img src="/storage/{{ $category->cover_photo }}" class="cover-photo" alt="Cover photo" /> @endif
        <input class="form-control no-border" style="padding: 6px 0" name="cover_photo" type="file" id="cover_photo" value="{{ $category->cover_photo or ''}}" >
        {!! $errors->first('cover_photo', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('is_active') ? 'has-error' : ''}}">
    <label for="is_active" class="col-md-4 control-label">{{ 'Is Active' }}</label>
    <div class="col-md-6">
        <div class="radio">
            <label><input name="is_active" type="radio" value="1" {{ (isset($category) && 1 == $category->is_active || !isset($category)) ? 'checked' : '' }}> Yes</label>
        </div>
        <div class="radio">
            <label><input name="is_active" type="radio" value="0" @if (isset($category)) {{ (0 == $category->is_active) ? 'checked' : '' }} @endif> No</label>
        </div>
        {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-4 col-md-4">
        <input class="btn btn-primary" type="submit" value="{{ $submitButtonText or 'Create' }}">
    </div>
</div>
