<div id="pswdModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">@lang('pages/user_profile.modal_pswd_title')</h4>
            </div>

            <div class="modal-body text-center">
                <form method="POST" action="{{ route('user_profile.changePassword') }}" class="container-fluid">
                    {{ csrf_field() }}
                    <div class="row form-group">
                        <label class="control-label col-lg-4" for="old_pswd">@lang('pages/user_profile.old_pswd')</label>
                        <div class="col-lg-6">
                            <input type="password" name="old_pswd" id="old_pswd" required/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="control-label col-lg-4" for="new_pswd">@lang('pages/user_profile.new_pswd')</label>
                        <div class="col-lg-6">
                            <input type="password" name="new_pswd" id="new_pswd" required/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="control-label col-lg-4" for="re_new_pswd">@lang('pages/user_profile.re_new_pswd')</label>
                        <div class="col-lg-6">
                            <input type="password" name="re_new_pswd" id="re_new_pswd" required/>
                        </div>
                    </div>

                    <div class="row" id="buttonRow">
                        <input id="changePassButton" type="submit" class="btn btn-primary" value="@lang('general.update')" disabled />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>

        $(document).ready(function () {

            var span = $('<div class="row form-group text-center alert-danger"></div>').insertBefore($('#buttonRow'));
            span.hide();

            $('#re_new_pswd').change(function (e) {
                e.preventDefault();
                var pswd1 = $('#new_pswd').val();
                var pswd2 = $('#re_new_pswd').val();

                if (pswd1.length==0 || pswd1=="") {
                    span.text('@lang('pages/user_profile.empty_pswd')');
                    span.show();
                    $('#changePassButton').prop('disabled', true);
                } else if (pswd1.length < 6) {
                    span.text('@lang('pages/user_profile.pswd_size_fail')');
                    span.show();
                    $('#changePassButton').prop('disabled', true);
                } else if (pswd1 != pswd2) {
                    span.text('@lang('pages/user_profile.pswd_dont_match')');
                    span.show();
                    $('#changePassButton').prop('disabled', true);
                } else {
                    span.hide();
                    $('#changePassButton').prop('disabled', false);
                }
            });
        });
    </script>
@endpush