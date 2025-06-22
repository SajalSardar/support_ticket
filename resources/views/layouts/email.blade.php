<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Order Confirmation</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap"
        rel="stylesheet" />
    <style>
        * {
            padding: 0;
            margin: 0;
            outline: 0;
            box-sizing: border-box;
        }

        p,
        a,
        ol,
        ul,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #ffffff;
        }

        table {
            border-spacing: 0;
            width: 100%;
            max-width: 700px;
            margin: 50px auto;
            border-radius: 8px;
            overflow: hidden;
        }

        td {
            padding: 10px 32px;
        }

        .header {
            text-align: center;
            background: #fff4ec;
            border-radius: 4px 4px 0 0;
        }

        .mt-32 {
            margin-top: 32px;
        }

        .mb-32 {
            margin-bottom: 32px;
        }

        .mt-12 {
            margin-top: 12px;
        }

        .mb-12 {
            margin-bottom: 12px;
        }

        .text-heading {
            font-size: 20px;
            font-weight: 600;
            font-family: "Inter", sans-serif;
            color: #333;
        }

        .text-title {
            font-size: 14px;
            font-weight: 600;
            font-family: "Inter", sans-serif;
            color: #333333;
        }

        .text-paragraph {
            font-size: 14px;
            font-weight: 600;
            font-family: "Inter", sans-serif;
            color: #5e666e;
        }

        .text-caption {
            font-size: 14px;
            font-weight: 400;
            font-family: "Inter", sans-serif;
            color: #5e666e;
        }
    </style>
</head>

<body>
    <table>
        <thead class="header">
            <tr>
                <td>
                    <img src="logo.png" alt="Logo" style="mix-blend-mode: color-burn;">
                </td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="border-left: 1px solid #ddd; border-right: 1px solid #ddd">
                    <h1 class="text-heading" style="padding-bottom: 24px;padding-top: 22px;">
                        Your Request Has Been Successfully Submitted!
                    </h1>
                    <p class="text-title" style="padding-bottom: 8px">Hello John,</p>
                    <p class="text-caption">
                        Thank you for reaching out to us. We have successfully received
                        your request, and our team is now reviewing the details. Below are
                        the specifics of your submission for your reference:
                    </p>
                </td>
            </tr>

            <tr>
                <td style="border-left: 1px solid #ddd; border-right: 1px solid #ddd">
                    <h3 class="text-title" style="padding-bottom: 8px">
                        Request Details:
                    </h3>
                    <p class="text-caption" style="padding-bottom: 4px">
                        <span class="text-paragraph">Request ID:</span> #RQ20231234
                    </p>
                    <p class="text-caption" style="padding-bottom: 4px">
                        <span class="text-paragraph">Submission Date:</span> November 18,
                        2024, 10:30 AM
                    </p>
                    <p class="text-caption" style="padding-bottom: 4px">
                        <span class="text-paragraph">Category: </span>Technical Support
                    </p>
                    <p class="text-caption">
                        <span class="text-paragraph">Description:</span> Unable to access
                        the student portal due to login errors.
                    </p>
                </td>
            </tr>

            <tr>
                <td style="border-left: 1px solid #ddd; border-right: 1px solid #ddd">
                    <h3 class="text-title" style="padding-bottom: 8px">
                        User Details:
                    </h3>
                    <p class="text-caption" style="padding-bottom: 4px">
                        <span class="text-paragraph">User Name: </span>thealamdev
                    </p>
                    <p class="text-caption" style="padding-bottom: 4px">
                        <span class="text-paragraph">Email:</span> thealamdev@gmail.com
                    </p>
                    <p class="text-caption">
                        <span class="text-paragraph">Password:</span> password@987
                    </p>
                </td>
            </tr>

            <tr>
                <td style="border-left: 1px solid #ddd; border-right: 1px solid #ddd">
                    <p class="text-caption">
                        If you need to provide additional information or have any further
                        questions, feel free to reply to this email or contact us at
                        support@logmyrequest.com or (123) 456-7890.
                    </p>

                    <p class="text-caption" style="padding-top: 12px">
                        Thank you for your patience and for choosing LogMyRequest. We’re
                        here to assist you!
                    </p>
                </td>
            </tr>

            <tr>
                <td style="border-left: 1px solid #ddd; border-right: 1px solid #ddd;padding-bottom: 32px; border-bottom:1px solid #ddd ;">
                    <h3 class="text-paragraph" style="padding-bottom: 4px">
                        Best Regards
                    </h3>
                    <p class="text-caption" style="padding-bottom: 4px">
                        Tech Support Team
                    </p>
                    <p class="text-caption" style="padding-bottom: 4px">LogMyRequest</p>
                    <p class="text-caption">
                        <span>https://www.logmyrequest.com</span> |
                        <span>support@logmyrequest.com</span> |
                        <span>(123) 456-7890</span>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>