<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 13px; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 800px; margin: 0 auto; background: #fff; padding: 30px; }
        .header { width: 100%; margin-bottom: 20px; }
        .header .logo { width: 150px; }
        .header .logo img { max-width: 150px; max-height: 80px; }
        .header .company-details { width: 50%; vertical-align: top; }
        .header .company-details strong { font-size: 16px; color: #000; }
        .header .company-details p { margin: 2px 0; }
        .header .invoice-details { width: 50%; text-align: right; vertical-align: top; }
        .header .invoice-details h2 { margin: 0 0 10px 0; font-size: 32px; font-weight: bold; color: #008cff; }
        .header .invoice-details td { padding: 2px 5px; }
        .details { width: 100%; margin-bottom: 20px; }
        .details .bill-to { background: #008cff; color: #fff; padding: 10px 15px; }
        .details .bill-to h3 { margin: 0 0 10px 0; font-size: 15px; font-weight: bold; }
        .details .bill-to p { margin: 2px 0; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th { background: #008cff; color: #fff; padding: 12px 10px; text-align: left; font-size: 12px; text-transform: uppercase; }
        .items-table td { padding: 12px 10px; border-bottom: 1px solid #eee; }
        .items-table .text-right { text-align: right; }
        .items-table tr.item-row { background: #f9f9f9; }
        .totals { width: 100%; }
        .totals .spacer { width: 60%; }
        .totals .totals-table { width: 40%; }
        .totals-table td { padding: 8px 10px; }
        .totals-table .label { text-align: right; font-weight: bold; color: #555; }
        .totals-table .value { text-align: right; }
        .totals-table .total-row td { background: #008cff; color: #fff; font-weight: bold; font-size: 18px; }
        .footer { margin-top: 30px; text-align: center; }
        .footer p { margin: 0 0 10px 0; white-space: pre-wrap; }
        .footer h4 { margin: 0; font-size: 16px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <table class="header">
            <tr>
                <td class="company-details">
                    @if($company->company_logo_url)
                        <img src="{{ $company->company_logo_url }}" alt="Logo" class="logo"><br>
                    @endif
                    <strong>{{ $company->company_name }}</strong><br>
                    <p>{{ $company->company_address }}</p>
                    <p>{{ $company->company_city_state_zip }}</p>
                    <p>Phone: {{ $company->company_phone }}</p>
                    <p>Email: {{ $company->company_email }}</p>
                </td>
                <td class="invoice-details">
                    <h2>INVOICE</h2>
                    <table>
                        <tr><td><strong>Date:</strong></td><td>{{ \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') }}</td></tr>
                        <tr><td><strong>Invoice #:</strong></td><td>{{ $invoice->invoice_number }}</td></tr>
                        <tr><td><strong>Due Date:</strong></td><td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="details">
            <tr>
                <td class="bill-to">
                    <h3>Bill To:</h3>
                    <p><strong>{{ $invoice->client->name }}</strong></p>
                    <p>{{ $invoice->client->address ?? 'N/A' }}</p>
                    <p>{{ $invoice->client->email ?? 'N/A' }}</p>
                    <p>{{ $invoice->client->phone ?? 'N/A' }}</p>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th class="text-right">Quantity</th>
                    <th>Description</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                <tr class="item-row">
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td><strong>{{ $item->product_name }}</strong></td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
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
                            <td class="label">Balance Due:</td>
                            <td class="value">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            <p>{{ $invoice->notes ?? $company->default_notes }}</p>
            <h4 style="margin-top: 20px;">Thank you for your business!</h4>
        </div>
    </div>
</body>
</html>
