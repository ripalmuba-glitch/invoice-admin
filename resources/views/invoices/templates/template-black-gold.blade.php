<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 13px; background: #fff; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 800px; margin: 0 auto; background: #fff; }
        .header { background: #1a1a1a; color: #fff; padding: 40px; }
        .header .title { font-size: 44px; font-weight: bold; color: #E0B000; margin: 0; }
        .header .invoice-details { width: 100%; margin-top: 15px; }
        .header .invoice-details td { padding: 2px 0; font-size: 14px; }
        .logo-container { text-align: right; }
        .logo-container .logo-circle { background: #E0B000; color: #000; border-radius: 50%; width: 100px; height: 100px; line-height: 100px; text-align: center; font-weight: bold; font-size: 18px; display: inline-block; overflow: hidden; }
        .logo-container img { max-width: 100%; max-height: 100%; vertical-align: middle; }
        .divider { width: 100%; height: 25px; background: #E0B000; border: none; }
        .details { width: 100%; padding: 30px 40px 10px 40px; }
        .details td { padding: 10px 0; vertical-align: top; width: 50%; }
        .details h3 { margin: 0 0 10px 0; font-size: 15px; text-transform: uppercase; color: #555; }
        .details p { margin: 2px 0; line-height: 1.6; }
        .items-table { width: 100%; border-collapse: collapse; padding: 0 40px; }
        .items-table th { background: #333; color: #fff; padding: 12px 10px; text-align: left; font-size: 12px; text-transform: uppercase; }
        .items-table td { padding: 12px 10px; border-bottom: 1px solid #eee; }
        .items-table .text-right { text-align: right; }
        .totals { width: 100%; padding: 20px 40px 30px 40px; }
        .totals .spacer { width: 55%; }
        .totals .totals-table { width: 45%; }
        .totals-table td { padding: 10px 15px; border-bottom: 1px solid #ddd; }
        .totals-table .label { text-align: right; font-weight: bold; color: #333; }
        .totals-table .value { text-align: right; font-weight: bold; }
        .totals-table .total-row td { background: #333; color: #fff; font-size: 18px; border: none; }
        .totals-table .total-row .value { color: #E0B000; }
        .footer { padding: 0 40px 40px 40px; }
        .footer h4 { margin: 20px 0 10px 0; font-size: 14px; text-transform: uppercase; color: #555; }
        .footer p { margin: 0; white-space: pre-wrap; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="container">
        <table class="header">
            <tr>
                <td style="width: 60%; vertical-align: top;">
                    <h1 class="title">INVOICE</h1>
                    <table class="invoice-details">
                        <tr><td style="width: 120px;"><strong>Invoice #:</strong></td><td>{{ $invoice->invoice_number }}</td></tr>
                        <tr><td><strong>Due Date:</strong></td><td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</td></tr>
                        <tr><td><strong>Invoice Date:</strong></td><td>{{ \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') }}</td></tr>
                    </table>
                </td>
                <td style="width: 40%; vertical-align: top;" class="logo-container">
                    <div class="logo-circle">
                         @if($company->company_logo_url)
                             <img src="{{ $company->company_logo_url }}" alt="Logo">
                         @else
                             LOGO
                         @endif
                    </div>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <table class="details">
            <tr>
                <td>
                    <h3>Bill To:</h3>
                    <p><strong>{{ $invoice->client->name }}</strong></p>
                    <p>{{ $invoice->client->address ?? 'N/A' }}</p>
                    <p>{{ $invoice->client->email ?? 'N/A' }}</p>
                    <p>{{ $invoice->client->phone ?? 'N/A' }}</p>
                </td>
                <td>
                    <h3>Bill From:</h3>
                    <p><strong>{{ $company->company_name }}</strong></p>
                    <p>{{ $company->company_address }}</p>
                    <p>{{ $company->company_email }}</p>
                    <p>{{ $company->company_phone }}</p>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Quantity</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                <tr>
                    <td><strong>{{ $item->product_name }}</strong></td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <td class="spacer"></td>
                <td class="totals-table">
                    <table>
                        <tr>
                            <td class="label">Subtotal:</td>
                            <td class="value">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @if ($invoice->discount > 0)
                        <tr>
                            <td class="label">Diskon:</td>
                            <td class="value">- Rp {{ number_format($invoice->discount, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        @if ($invoice->tax > 0)
                        <tr>
                            <td class="label">Pajak ({{ round(($invoice->tax / ($invoice->subtotal - $invoice->discount)) * 100, 2) }}%):</td>
                            <td class="value">+ Rp {{ number_format($invoice->tax, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr class="total-row">
                            <td class="label">Amount Due:</td>
                            <td class="value">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            <h4>Notes / Terms & Conditions:</h4>
            <p>{{ $invoice->notes ?? $company->default_notes }}</p>
        </div>
    </div>
</body>
</html>
