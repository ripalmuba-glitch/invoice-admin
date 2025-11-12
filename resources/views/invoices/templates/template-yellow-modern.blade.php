<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 13px; line-height: 1.6; }
        .container { width: 100%; max-width: 800px; margin: 0 auto; background: #fff; padding: 40px; }
        table { width: 100%; border-collapse: collapse; }
        .header { margin-bottom: 30px; }
        .header td { vertical-align: top; }
        .header .logo img { max-width: 150px; max-height: 80px; }
        .header .company-details { text-align: right; }
        .header .company-name { font-size: 24px; font-weight: bold; color: #000; }
        .header .company-details p { margin: 2px 0; }
        .yellow-bar { background: #fecb00; height: 10px; border: none; margin: 30px 0; }
        .details { margin-bottom: 30px; }
        .details td { width: 50%; vertical-align: top; }
        .details .bill-to h3 { margin: 0 0 10px 0; font-size: 14px; text-transform: uppercase; color: #555; }
        .details .bill-to p { margin: 2px 0; }
        .details .invoice-details { text-align: right; }
        .details .invoice-details .invoice-title { font-size: 28px; font-weight: bold; color: #000; margin: 0 0 10px 0; }
        .details .invoice-details .detail-item { margin-bottom: 5px; font-size: 14px; }
        .items-table { margin-bottom: 30px; }
        .items-table th { background: #3a3a3a; color: #fff; padding: 12px 10px; text-align: left; font-size: 12px; text-transform: uppercase; }
        .items-table td { padding: 12px 10px; border-bottom: 1px solid #eee; }
        .items-table .text-right { text-align: right; }
        .totals { }
        .totals .spacer { width: 60%; }
        .totals .totals-table { width: 40%; }
        .totals-table td { padding: 8px 10px; }
        .totals-table .label { text-align: right; font-weight: bold; color: #555; }
        .totals-table .value { text-align: right; }
        .totals-table .total-row td { background: #fecb00; color: #000; font-weight: bold; font-size: 18px; padding: 12px; }
        .footer { margin-top: 40px; border-top: 2px solid #fecb00; padding-top: 20px; }
        .footer h4 { margin: 0 0 10px 0; font-size: 14px; color: #555; }
        .footer p { margin: 0; white-space: pre-wrap; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <table class="header">
            <tr>
                <td class="logo">
                    @if($company->company_logo_url)
                        <img src="{{ $company->company_logo_url }}" alt="Logo">
                    @endif
                </td>
                <td class="company-details">
                    <div class="company-name">{{ $company->company_name }}</div>
                    <p>{{ $company->company_address }}</p>
                    <p>{{ $company->company_city_state_zip }}</p>
                    <p>{{ $company->company_phone }} | {{ $company->company_email }}</p>
                </td>
            </tr>
        </table>

        <div class="yellow-bar"></div>

        <table class="details">
            <tr>
                <td class="bill-to">
                    <h3>INVOICE TO:</h3>
                    <p><strong>{{ $invoice->client->name }}</strong></p>
                    <p>{{ $invoice->client->address ?? 'N/A' }}</p>
                    <p>{{ $invoice->client->email ?? 'N/A' }}</p>
                    <p>{{ $invoice->client->phone ?? 'N/A' }}</p>
                </td>
                <td class="invoice-details">
                    <div class="invoice-title">INVOICE</div>
                    <div class="detail-item"><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</div>
                    <div class="detail-item"><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') }}</div>
                    <div class="detail-item"><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>ITEM DESCRIPTION</th>
                    <th class="text-right">PRICE</th>
                    <th class="text-right">QTY.</th>
                    <th class="text-right">TOTAL</th>
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
                            <td class="label">Sub Total:</td>
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
                            <td class="label">Total:</td>
                            <td class="value">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            <h4>Terms & Conditions / Payment Info:</h4>
            <p>{{ $invoice->notes ?? $company->default_notes }}</p>
        </div>
    </div>
</body>
</html>
