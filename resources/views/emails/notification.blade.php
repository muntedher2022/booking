<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700" rel="stylesheet" media="screen">

    <style>
        body {
            margin: 0; width: 100%; padding: 0; word-break: break-word; -webkit-font-smoothing: antialiased;
        }
        .px-48 {
            padding-left: 48px;
            padding-right: 48px;
        }
        .py-48 {
            padding-top: 48px;
            padding-bottom: 48px;
        }
        .hover-underline:hover {
            text-decoration: underline !important;
        }

        @media (max-width: 600px) {
            .sm-w-full {
                width: 100% !important;
            }

            .sm-px-24 {
                padding-left: 24px !important;
                padding-right: 24px !important;
            }

            .sm-py-32 {
                padding-top: 32px !important;
                padding-bottom: 32px !important;
            }
        }
    </style>

</head>

<body>
    <div role="article" aria-roledescription="email" aria-label="" style="margin-top: 30px; font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
        <table style="width: 100%; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center" style="mso-line-height-rule: exactly; background-color: #eceff1; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;">
                    <table class="sm-w-full" style="width: 600px;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                                <table style="width: 100%;" cellpadding="0" cellspacing="0">
                                    <tr style="text-align: center">
                                        <td class="px-48" style="mso-line-height-rule: exactly; border-radius: 4px; background-color: #ffffff;  text-align: left; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 16px; line-height: 24px; color: #626262;">
                                            <p align="right" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 20px; font-weight: 600;">
                                                تهديكم {{ $title }} اطيب التحية
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align='right' class="px-48 py-48" style="mso-line-height-rule: exactly; border-radius: 4px; background-color: #ffffff; text-align: left; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 16px; line-height: 24px; color: #626262;">
                                            <p align="right" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 20px; font-weight: 600;">
                                                مرحبا
                                            </p>
                                            <p align="right" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 24px; font-weight: 700; color: #000000;">
                                                {{ $fullName }}
                                            </p>
                                            <p align="right" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; margin-bottom: 24px;">
                                                شكراً لك على دفع الرسوم الخاصة بالعقار المبينة تفاصيله ادناه،<br>هذه فاتورة لعملية الدفع الأخيرة التي قمت بها
                                            </p>

                                            <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td align="left" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                                                        <h3 style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; text-align: left; font-size: 14px; font-weight: 700;">
                                                            {{ $receipt_date }}
                                                        </h3>
                                                    </td>
                                                    <td align="right" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                                                        <h3 style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; text-align: right; font-size: 14px; font-weight: 700;">
                                                            #{{ $receipt_number }}
                                                        </h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                                                        <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                                            <tr>
                                                                <th align="left" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; padding-bottom: 8px;">
                                                                    <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                                                                        المبلغ
                                                                    </p>
                                                                </th>
                                                                <th align="right" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; padding-bottom: 8px;">
                                                                    <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                                                                        الوصف
                                                                    </p>
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; width: 20%; padding-top: 10px; padding-bottom: 10px; font-size: 16px;">
                                                                    {{ $amount }}
                                                                </td>
                                                                <td align="right" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; width: 80%; text-align: right; font-size: 16px;">
                                                                    دفع الرسوم الخاصة بالعقار المرقم {{ $Bonds->property_number }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; width: 20%;">
                                                                    <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; text-align: right; font-size: 16px; font-weight: 700; line-height: 24px;">
                                                                        {{ $amount }}
                                                                    </p>
                                                                </td>
                                                                <td align="right" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; width: 80%;">
                                                                    <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin: 0; padding-right: 16px; text-align: right; font-size: 16px; font-weight: 700; line-height: 24px;">
                                                                        المجموع
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <p style="height: 2px; width: 100%; margin-top:20px; margin-bottom: 20px; background-color: #666"></p>

                                            <p align="right">
                                                <b>تفاصل العقار</b>
                                            </p>

                                            <p>
                                                <table style="width: 100%;" cellpadding="0" cellspacing="0" style="text-align: center">
                                                    <tr style="text-align: center">
                                                        <td>رقم المقاطعة</td>
                                                        <td>رقم القطعة</td>
                                                        <td>رقم العقار</td>
                                                    </tr>
                                                    <tr style="text-align: center">
                                                        <td>{{ $Bonds->boycott_id }}</td>
                                                        <td>{{ $Bonds->part_number }}</td>
                                                        <td>{{ $Bonds->property_number }}</td>
                                                    </tr>
                                                </table>
                                            </p>

                                            <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; padding: 16px; font-size: 16px;">
                                                        <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                                            <tr style="text-align: center">
                                                                <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; font-size: 16px;">
                                                                    <strong>المبلغ المستحق</strong>
                                                                    <p>{{ number_format($totalAmount) }}</p>
                                                                </td>
                                                                <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; font-size: 16px;">
                                                                    <strong>المبلغ المدفوع</strong>
                                                                    <p>{{ number_format($AmountPaid) }}</p>
                                                                </td>
                                                                <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; font-size: 16px;">
                                                                    <strong>المبلغ المتبقي</strong>
                                                                    <p>{{ number_format($RemainingAmount) }}</p>
                                                                </td>
                                                            </tr>
                                                            <!-- <tr>
                                                                <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; font-size: 16px;">
                                                                    <strong>Due By:</strong> 18th June 2020
                                                                </td>
                                                            </tr> -->
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- <table align="right"
                                                style="margin-left: auto; margin-right: auto; width: 100%; text-align: center;"
                                                cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td align="right"
                                                        style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                                                        <table style="margin-top: 24px; margin-bottom: 24px;"
                                                            cellpadding="0" cellspacing="0" role="presentation">
                                                            <tr>
                                                                <td align="right"
                                                                    style="mso-line-height-rule: exactly; mso-padding-alt: 16px 24px; border-radius: 4px; background-color: #7367f0; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;">
                                                                    <a href="https://example.com" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; display: block; padding-left: 24px; padding-right: 24px; padding-top: 16px; padding-bottom: 16px; font-size: 16px; font-weight: 600; line-height: 100%; color: #ffffff; text-decoration: none;">Pay
                                                                        Invoice &rarr;
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table> -->

                                            <p style="height: 2px; width: 100%; margin-top:20px; margin-bottom: 20px; background-color: #666"></p>

                                            <p align='right' style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 6px; margin-bottom: 20px; font-size: 16px; line-height: 24px;">
                                                إذا كانت لديك أي أسئلة بخصوص هذه الفاتورة، فما عليك سوى الرد على هذا البريد الإلكتروني أو التواصل مع فريق الدعم الخاص بنا للحصول على المساعدة.
                                                <a href="#" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                                                    فريق الدعم
                                                </a> للمساعدة.
                                            </p>
                                            <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 6px; margin-bottom: 20px; font-size: 16px; line-height: 24px;">
                                                تحيات شركة الموانئ العراقية
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; height: 20px;"></td>
                        </tr>
                        <!-- <tr>
                            <td style="mso-line-height-rule: exactly; padding-left: 48px; padding-right: 48px; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 14px; color: #eceff1;">
                                <p align="center" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 16px; cursor: default;">
                                    <a href="https://www.facebook.com/pixinvents" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #263238; text-decoration: none;"><img
                                        src="images/facebook.png" width="17" alt="Facebook" style="max-width: 100%; vertical-align: middle; line-height: 100%; border: 0; margin-right: 12px;"></a>
                                    &bull;
                                    <a href="https://twitter.com/pixinvents" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #263238; text-decoration: none;"><img
                                            src="images/twitter.png" width="17" alt="Twitter" style="max-width: 100%; vertical-align: middle; line-height: 100%; border: 0; margin-right: 12px;"></a>
                                    &bull;
                                    <a href="https://www.instagram.com/pixinvents" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #263238; text-decoration: none;"><img
                                            src="images/instagram.png" width="17" alt="Instagram" style="max-width: 100%; vertical-align: middle; line-height: 100%; border: 0; margin-right: 12px;"></a>
                                </p>
                                <p style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #263238;">
                                    Use of our service and website is subject to our
                                    <a href="https://pixinvent.com/" class="hover-underline" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #7367f0; text-decoration: none;">Terms
                                        of Use
                                    </a> and
                                    <a href="https://pixinvent.com/" class="hover-underline" style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #7367f0; text-decoration: none;">Privacy
                                        Policy
                                    </a>.
                                </p>
                            </td>
                        </tr> -->
                        <tr>
                            <td style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; height: 16px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
