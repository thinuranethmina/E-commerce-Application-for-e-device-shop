<table class="letter-content" align="center">
    <tr>
        <td>
            <h1 class="title">
                {{ $title }}
            </h1>
        </td>
    </tr>
    <tr>
        <td>
            <p style="text-align: left;">
                Dear Admin,
            </p>
            <p style="text-align: left;">
                A new form has been submitted on DigiMax.lk Please review the details below:
                <br><br>
                Applicant Details:
                <br><br>
                Name: <strong>{{ $name }}</strong> <br><br>
                Email: <strong>{{ $email }}</strong> <br><br>
                Message: {{ $message }} <br><br>
                Submitted Date: {{ $date }}
            </p>
        </td>
    </tr>
</table>
