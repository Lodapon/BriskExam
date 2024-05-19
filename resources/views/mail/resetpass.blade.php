@extends("mail.template")
@section("content.tr")

    <tr>
        <td style="padding: 0px 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
            <h1 style="margin: 0 0 10px; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">Hi, {{ $accountName }}</h1>
            <p style="margin: 0 0 10px;">You have requested to reset password.</p>
            <p style="margin: 0 0 10px; color: orangered">If this not from you, please DO NOT click the link.</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 20px 20px;">
            <br/>
            <!-- Button : BEGIN -->
            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                <tbody><tr>
                    <td class="button-td button-td-primary" style="border-radius: 4px; background: #222222;">
                        <a class="button-a button-a-primary" href="{{ $link }}" style="background: #222222; border: 1px solid #000000; font-family: sans-serif; font-size: 15px; line-height: 15px; text-decoration: none; padding: 13px 17px; color: #ffffff; display: block; border-radius: 4px;">Reset Password</a>
                    </td>
                </tr>
                </tbody></table>
            <!-- Button : END -->
        </td>
    </tr>

@endsection