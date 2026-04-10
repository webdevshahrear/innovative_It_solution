<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_no }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; margin: 0; padding: 20px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px; line-height: 24px; color: #555; background: #fff; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.top table td.title { font-size: 45px; line-height: 45px; color: #333; }
        .invoice-box table tr.information table td { padding-bottom: 40px; }
        .invoice-box table tr.heading td { background: #f8fafc; border-bottom: 1px solid #ddd; font-weight: bold; padding: 10px; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; padding: 15px 10px; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #f05223; font-weight: bold; font-size: 1.2rem; padding-top: 10px; }
        .brand-orange { color: #f05223; font-weight: 800; }
        
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
            .invoice-box { border: none; box-shadow: none; width: 100%; max-width: 100%; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #f05223; color: white; border: none; border-radius: 5px; font-weight: bold;">PRINT / DOWNLOAD PDF</button>
    </div>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <span class="brand-orange">INNOVATIVE</span> IT
                            </td>
                            <td>
                                Invoice #: {{ $invoice->invoice_no }}<br>
                                Issued: {{ $invoice->created_at->format('M d, Y') }}<br>
                                <strong>Due: {{ $invoice->due_date->format('M d, Y') }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Innovative IT Solutions</strong><br>
                                123 Web St, Tech City<br>
                                Dhaka, Bangladesh<br>
                                billing@innovativeit.com
                            </td>
                            <td>
                                <strong>{{ $invoice->client->name }}</strong><br>
                                {{ $invoice->client->company_name ?? 'Individual Client' }}<br>
                                {{ $invoice->client->email }}<br>
                                {{ $invoice->client->phone ?? '' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Description</td>
                <td>Amount</td>
            </tr>

            <tr class="item">
                <td>
                    {{ $invoice->notes ?? 'Professional Services & Digital Transformation Solutions' }}
                </td>
                <td>${{ number_format($invoice->amount, 2) }}</td>
            </tr>

            <tr class="item last">
                <td>Tax / VAT</td>
                <td>${{ number_format($invoice->tax, 2) }}</td>
            </tr>

            <tr class="total">
                <td></td>
                <td>Total: ${{ number_format($invoice->amount + $invoice->tax, 2) }}</td>
            </tr>
        </table>
        
        <div style="margin-top: 50px; border-top: 1px solid #efefef; padding-top: 20px; font-size: 12px; color: #999;">
            <p><strong>Payment Terms:</strong> Please remit payment by the due date mentioned above. Bank transfer details will be shared upon request.</p>
            <p>Thank you for choosing Innovative IT Solutions for your digital growth!</p>
        </div>
    </div>
</body>
</html>
