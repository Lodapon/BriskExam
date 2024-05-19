@extends('layouts.mainlayout')
@section('content')
    <div class="wrapper">
        <section class="sign-in-page">
            <div class="container p-0">
                <div class="row no-gutters">
                    <div class="col-sm-12 align-self-center">
                        <div class="sign-in-from bg-white">
                            <form id="confirmForm" class="mt-4" action="#" method="post">
                                @csrf
                                <input type="hidden" id="resetToken" value="{{ $resetToken }}"/>
                                <div class="form-group">
                                    <label for="password1">New Password</label>
                                    <input type="password" class="form-control mb-0" id="password1" name="password1" placeholder="*****">
                                </div>
                                <div class="form-group">
                                    <label for="password2">Confirm New Password</label>
                                    <input type="password" class="form-control mb-0" id="password2" name="password2" placeholder="*****">
                                </div>
                                <div class="d-inline-block w-100">
                                    <button type="button" id="confirmReset" class="btn btn-danger float-right">Reset Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Wrapper END -->
    <script type="text/javascript" src="{{ asset('/assets-custom/reset-pass.js') }}"></script>
@endsection

