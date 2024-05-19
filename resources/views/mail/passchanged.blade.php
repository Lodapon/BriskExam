@extends("mail.template")
@section("content.tr")

    <tr>
        <td style="padding: 0px 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
            <h1 style="margin: 0 0 10px; font-size: 25px; line-height: 30px; color: #333333; font-weight: normal;">Hi, {{ $accountName }}</h1>
            <p style="margin: 0 0 10px;">You password has been changed successfully.</p>
            <p style="margin: 0 0 10px; color: orangered">If this not from you, please reset your password immediately.</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 0 20px 20px;">
            <br/>

        </td>
    </tr>

@endsection