@extends('layouts.mainlayout')
@section('content')
    <div class="wrapper">
        <section class="sign-in-page">
            <div class="container p-0">
                <div class="row no-gutters">
                    <div class="col-sm-12 align-self-center">
                        <div class="sign-in-from bg-white">
                            <form id="requestForm" class="mt-4" action="#" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control mb-0" id="email" placeholder="Enter email">
                                </div>
                                <div class="d-inline-block w-100">
                                    <button type="button" id="requestReset" class="btn btn-danger float-right">Reset Password</button>
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

