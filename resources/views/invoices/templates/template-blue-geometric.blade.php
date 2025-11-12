<!DOCTYPE html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 13px; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 800px; margin: 0 auto; background: #fff; padding: 0; }
        .geometric-header {
            background-color: #0d47a1; /* Biru tua */
            color: #fff;
            padding: 30px;
        }
        .geometric-header img { max-width: 120px; max-height: 80px; }
        .geometric-header h3 { margin: 20px 0 10px 0; font-size: 15px; text-transform: uppercase; color: #bbdefb; }
        .geometric-header p { margin: 2px 0; line-height: 1.6; }
        .content { padding: 30px; }
        .header { width: 100%; margin-bottom: 30px; }
        .header .invoice-details { text-align: right; }
        .header .invoice-details h2 { margin: 0 0 10px 0; font-size: 28px; font-weight: bold; color: #0d47a1; }
        .header .invoice-details .detail-item { margin-bottom: 5px; font-size: 14px; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .items-table th { background: #f4f4f4; padding: 12px 10px; text-align: left; font-size: 12px; text-transform: uppercase; color: #555; }
        .items-table td { padding: 12px 10px; border-bottom: 1px solid #eee; }
        .items-table .text-right { text-align: right; }
        .totals { width: 100%; margin-top: 30px; }
        .totals .spacer { width: 55%; }
        .totals .totals-table { width: 45%; }
        .totals-table td { padding: 8px 10px; }
        .totals-table .label { text-align: right; font-weight: bold; color: #555; }
        .totals-table .value { text-align: right; }
        .totals-table .total-row .label, .totals-table .total-row .value { color: #0d47a1; font-weight: bold; font-size: 18px; border-top: 2px solid #ddd; padding-top: 10px; }
        .footer { padding: 30px; padding-top: 0; }
        .footer h4 { margin: 0 0 10px 0; font-size: 14px; text-transform: uppercase; color: #555; }
        .footer p { margin: 0; white-space: pre-wrap; line-height: 1.6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="geometric-header">
            @if($company->company_logo_url)
                <img src="{{ $company->company_logo_url }}" alt="Logo"><br>
            @endif
            <h3>Invoice To:</h3>
            <p><strong>{{ $invoice->client->name }}</strong></p>
            <p>{{ $invoice->client->address ?? 'N/A' }}</p>
            <p>{{ $invoice->client->email ?? 'N/A' }}</p>
            <p>{{ $invoice->client->phone ?? 'N/A' }}</p>
        </div>

        <div class="content">
            <table class="header">
                <tr>
                    <td class="invoice-details">
                        <h2>INVOICE</h2>
                        <div class="detail-item"><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</div>
                        <div class="detail-item"><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->issue_date)->format('d/m/Y') }}</div>
                        <div class="detail-item"><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d/m/Y') }}</div>
                    </td>
                </tr>
            </table>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item Description</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Qty.</th>
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
        </div>

        <div class="footer">
            <h4>Terms & Conditions / Payment Info:</h4>
            <p>{{ $invoice->notes ?? $company->default_notes }}</p>
        </div>
    </div>
</body>
</html>
