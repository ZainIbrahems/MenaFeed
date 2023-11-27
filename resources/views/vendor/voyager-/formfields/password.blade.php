@if(isset($dataTypeContent->{$row->field}))
    <br>
@endif
<input type="password"
       @if($row->required == 1 && !isset($dataTypeContent->{$row->field})) required @endif
       class="form-control"
       placeholder="{{ __('voyager::form.field_password_keep') }}"
       name="{{ $row->field }}"
       value="">
