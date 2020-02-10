<?php
$lang = config('default_lang');
if (isset($state))
    $lang = $state->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<style>
    .btn.btn-large.btn-primary {
        width: 100%;
    }
</style>
<div class="form-body">        
    {!! Form::hidden('id', null) !!}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'lang') !!}" id="lang_div">
        {!! Form::label('lang', __('Language'), ['class' => 'bold']) !!}
        {!! Form::select('lang', ['' => __('Select Language')]+$languages, $lang, array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'setLang(this.value);')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'lang') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_id') !!}" id="country_id_div">
        {!! Form::label('country_id', __('Danger Category'), ['class' => 'bold']) !!}
        {!! Form::select('country_id', $countries, old('country_id'), array('class'=>'form-control', 'id'=>'country_id', 'onchange'=>'filterDefaultStates(0);')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'country_id') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'state') !!}">
        {!! Form::label('state', __('Danger Sub Category'), ['class' => 'bold']) !!}
        {!! Form::text('state', null, array('class'=>'form-control', 'id'=>'state', 'placeholder'=>__('Danger Sub Category'), 'dir'=>$direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'state') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Is Active?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
            $is_active_1 = 'checked="checked"';
            $is_active_2 = '';
            if (old('is_active', ((isset($state)) ? $state->is_active : 1)) == 0) {
                $is_active_1 = '';
                $is_active_2 = 'checked="checked"';
            }
            ?>
            <label class="radio-inline">
                <input id="active" name="is_active" type="radio" value="1" {{$is_active_1}}>
                Active </label>
            <label class="radio-inline">
                <input id="not_active" name="is_active" type="radio" value="0" {{$is_active_2}}>
                In-Active </label>
        </div>			
        {!! APFrmErrHelp::showErrors($errors, 'is_active') !!}
    </div>	
    <div class="form-actions">
        {!! Form::button('حفظ <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')) !!}
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    function setLang(lang) {
        window.location.href = "<?php echo url(Request::url()) . $queryString; ?>" + lang;
    }
    function showHideStateId() {
        $('#state_id_div').hide();
        var is_default = $("input[name='is_default']:checked").val();
        if (is_default == 0) {
            $('#state_id_div').show();
        }
    }
    showHideStateId();
    {{--function filterDefaultStates(state_id)--}}
    {{--{--}}
    {{--    var country_id = $('#country_id').val();--}}
    {{--    if (country_id != '') {--}}
    {{--        $.post("{{ route('filter.default.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})--}}
    {{--                .done(function (response) {--}}
    {{--                    $('#default_state_dd').html(response);--}}
    {{--                });--}}
    {{--    }--}}
    {{--}--}}
    {{--filterDefaultStates(<?php echo old('state_id', (isset($state)) ? $state->state_id : 0); ?>);--}}
</script>
@endpush