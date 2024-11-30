<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Contract Agreement</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }

        h1, h2 {
            color: #333;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .contract-info, .party-info, .payment-info, .financial-summary {
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .checkbox {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 2px solid #000;
            margin-right: 10px;
            vertical-align: middle;
            border-radius: 3px;
        }

        .checkbox.x {
            background-color: #000;
        }

        .section-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }

        .signature-line {
            display: inline-block;
            width: 300px;
            border-top: 1px solid #000;
            margin-top: 30px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <h1>Rental Contract Agreement</h1>

    <div class="contract-info">
        <h2>Contract Information</h2>
        {{-- <p><span class="section-label">Contract Type:</span> 
            [<span class="checkbox {{ $contract->contract_type == 'fixed' ? 'x' : '' }}"></span>] Fixed 
            [<span class="checkbox {{ $contract->contract_type == 'monthly' ? 'x' : '' }}"></span>] Monthly 
            [<span class="checkbox {{ $contract->contract_type == 'annual' ? 'x' : '' }}"></span>] Annual 
            [<span class="checkbox {{ $contract->contract_type == 'one_time' ? 'x' : '' }}"></span>] One-Time
        </p> --}}
        <p><span class="section-label">Contract Status:</span> 
            [<span class="checkbox {{ $contract->status == 'active' ? 'x' : '' }}"></span>] Active 
            [<span class="checkbox {{ $contract->status == 'expired' ? 'x' : '' }}"></span>] Expired 
            [<span class="checkbox {{ $contract->status == 'terminated' ? 'x' : '' }}"></span>] Terminated
        </p>
        <p><span class="section-label">Is Renewable:</span> 
            [<span class="checkbox {{ $contract->is_renewable ? 'x' : '' }}"></span>] Yes 
            [<span class="checkbox {{ !$contract->is_renewable ? 'x' : '' }}"></span>] No
        </p>
    </div>

    <div class="party-info">
        <h2>Parties Involved</h2>
        <p><span class="section-label">Tenant Name:</span> {{ $contract->tenant->name }}</p>
        <p><span class="section-label">Tenant ID:</span> {{ $contract->tenant->id }}</p>
        <p><span class="section-label">Property Name:</span> {{ $contract->property->name }}</p>
        <p><span class="section-label">Property ID:</span> {{ $contract->property->id }}</p>
    </div>

    <div class="contract-info">
        <h2>Contract Dates</h2>
        <p><span class="section-label">Contract Start Date:</span> {{ $contract->start_date->format('Y-m-d') }}</p>
        <p><span class="section-label">Contract End Date:</span> {{ optional($contract->end_date)->format('Y-m-d') }}</p>
        <p><span class="section-label">Renewal Date:</span> {{ optional($contract->renewal_date)->format('Y-m-d') }}</p>
    </div>

    <div class="signatures">
        <h2>Signatures</h2>
        <p><span class="section-label">Landlord:</span> <span class="signature-line"></span></p>
        <p><span class="section-label">Tenant:</span> <span class="signature-line"></span></p>
    </div>

    <div class="payment-info">
        <h2>Payment Details</h2>
        <p><span class="section-label">Rent Amount:</span> ${{ number_format($contract->rent_amount, 2) }}</p>
        <p><span class="section-label">Security Payment:</span> ${{ number_format($contract->security_payment, 2) }}</p>
        <p><span class="section-label">Payment Frequency:</span> {{ ucfirst($contract->payment_frequency) }}</p>
        <p><span class="section-label">Payment Due Date:</span> {{ $contract->payment_due_date->format('Y-m-d') }}</p>
        <p><span class="section-label">Late Fee:</span> ${{ number_format($contract->late_fee, 2) }}</p>
    </div>

    <div class="financial-summary">
        <h2>Financial Summary</h2>
        <p><span class="section-label">Total Paid by Tenant:</span> ${{ number_format($contract->total_paid, 2) }}</p>
        <p><span class="section-label">Outstanding Amount:</span> ${{ number_format($contract->rent_amount - $contract->total_paid, 2) }}</p>
    </div>

    <div class="contract-info">
        <h2>Special Terms & Notes</h2>
        <p><span class="section-label">Special Terms:</span> {{ $contract->special_terms }}</p>
        <p><span class="section-label">Notes:</span> {{ $contract->notes }}</p>
    </div>

    <div class="signatures">
        <h2>Signatures</h2>
        <p><span class="section-label">Landlord:</span> <span class="signature-line"></span></p>
        <p><span class="section-label">Tenant:</span> <span class="signature-line"></span></p>
    </div>

    <div class="footer">
        <p>Agreement created on {{ now()->format('Y-m-d') }}.</p>
    </div>

</body>
</html>
