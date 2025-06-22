<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap"
        rel="stylesheet" />
    <title>Request Assigned</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            outline: 0;
        }

        body {
            font-family: "Inter", serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333333;
        }

        td,
        p,
        a,
        h1 {
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 700px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 8px;
            overflow: hidden;
        }

        .content {
            padding: 0 32px;
        }

        .content h1 {
            font-family: "Inter", serif;
            font-weight: 500;
            font-size: 18px;
            color: #27313b;
            margin-bottom: 32px;
            text-align: center;
        }

        .content p {
            font-family: "Inter", serif;
            font-weight: 400;
            font-size: 14px;
            margin: 5px 0;
            line-height: 1.4;
        }

        .titleHeading {
            font-weight: 500 !important;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details-table td {
            padding: 2px !important;
            font-size: 14px;
            vertical-align: top;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666666;
            border-top: 1px solid #eaeaea;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .warning {
            color: #d9534f;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <table
        class="email-container"
        cellspacing="0"
        cellpadding="0"
        border="0"
        align="center">
        <tr>
            <td align="center" style="padding: 32px 0">
                <!-- Circle Container -->
                <table
                    width="116"
                    height="116"
                    border="0"
                    cellspacing="0"
                    cellpadding="0"
                    style="
              background-color: #fffaf6;
              border-radius: 50%;
              text-align: center;
            ">
                    <tr>
                        <td align="center" style="line-height: 0">
                            <img
                                src="https://res.cloudinary.com/doffuwqxx/image/upload/v1735625159/check_amxayi.png"
                                alt="Success Icon"
                                width="50"
                                height="50"
                                style="display: block" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="content">
                <h1>Your Request Has Been Successfully Created!</h1>
                <p class="titleHeading" style="padding-left: 4px">{{ $ticket?->requester_name }},</p>
                <p style="padding-left: 4px">
                    Thank you for submitting your request. We've received your details,
                    and our team is already working to address your query. Below are the
                    details of your request for your reference:
                </p>
                <table
                    class="details-table"
                    cellspacing="0"
                    cellpadding="0"
                    border="0">
                    <tr>
                        <td>
                            <span class="titleHeading">Request Details</span>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="titleHeading">Request ID :</span> {{ $id }}</td>
                    </tr>
                    <tr>
                        <td>
                            <span class="titleHeading">Due Date:</span> {{ $ticket->due_date }}
                        </td>
                    </tr>
                    <tr>
                        <td><span class="titleHeading">Email :</span> {{ $ticket->requester_email  }}</td>
                    </tr>
                    @if ($ticket->credentials == '1')
                    <tr>
                        <td>
                            <span class="titleHeading">Password :</span> {{ $ticket->password }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>
                            <span class="titleHeading">Category :</span> {{ $ticket?->category_id }}
                        </td>
                    </tr>
                    <tr>
                        <td><span class="titleHeading">Priority :</span>{{ $ticket?->priority }}</td>
                    </tr>
                    <tr>
                        <td>
                            <span class="titleHeading">Description :</span> {!! $ticket?->request_description !!}.
                        </td>
                    </tr>
                </table>
                <div style="margin:32px 0px; margin-left: 4px">
                    <p class="titleHeading">Best regards,</p>
                    <p>LogMyRequest Support Team</p>
                    <p>
                        <a href="https://www.logmyrequest.com">https://www.logmyrequest.com</a>
                    </p>
                    <p class="warning" style="margin-top: 30px">
                        Please don't share your credentials with others
                    </p>
                </div>
            </td>
        </tr>
        <tr>
            <td class="footer">&copy; 2024 LogMyRequest. All rights reserved.</td>
        </tr>
    </table>
</body>

</html>