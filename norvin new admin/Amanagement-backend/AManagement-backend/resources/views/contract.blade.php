<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boarding House Contract Agreement</title>
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

        p {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .section-label {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 50px;
        }

        .signature-line {
            display: inline-block;
            width: 300px;
            border-top: 1px solid #000;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h1>BOARDING HOUSE CONTRACT AGREEMENT</h1>

    <p>This agreement is made between <span class="section-label">[{{$contract->tenant->name}}]</span> ("Tenant") and <span class="section-label">[{{$contract->property->name}}]</span> ("Management") on this day, <span class="section-label">{{ $contract->contract_date->format('F j, Y') }}</span>. The Tenant agrees to occupy the premises located at <span class="section-label">{{ $contract->property->address }}</span> for the duration of the contract, under the terms and conditions set forth in this agreement.</p>

    <h2>1. Contract Term</h2>
    <p>The tenancy shall commence on <span class="section-label">{{ $contract->start_date->format('F j, Y') }}</span> and will end on <span class="section-label">{{ optional($contract->end_date)->format('F j, Y') }}</span> (if applicable). If the contract is of a monthly or annual nature, the agreement will renew automatically unless either party terminates the contract with a written notice of <span class="section-label">{{ $contract->notice_period }} days</span>.</p>

    <h2>2. Payment Terms</h2>
    <p>The Tenant agrees to pay a monthly rent of <span class="section-label">₱{{ number_format($contract->rent_amount, 2) }}</span>, which is due on the <span class="section-label">{{ $contract->payment_due_day }}</span> of each month. Payments should be made directly to the Management or designated account. If payment is not received by the due date, a late fee of <span class="section-label">₱{{ number_format($contract->late_fee, 2) }}</span> will be charged. If rent remains unpaid for two consecutive months, the Management has the right to terminate the tenancy and require the Tenant to vacate the premises, subject to the settlement of outstanding obligations.</p>

    <h2>3. Security Deposit</h2>
    <p>A security deposit of <span class="section-label">₱{{ number_format($contract->security_deposit_amount, 2) }}</span> is required, which will be refundable upon the completion of the contract, provided the Tenant has complied with all terms, including the condition of the property and timely payment of rent.</p>

    <h2>4. House Rules and Regulations</h2>
    <p>The Tenant agrees to adhere to all house rules, including but not limited to:</p>
    <ul>
        <li>No loud noises, parties, or disturbances that may disrupt other tenants.</li>
        <li>No pets unless otherwise agreed by Management.</li>
        <li>Smoking is prohibited within the premises.</li>
        <li>Alcohol and intoxicating substances are prohibited.</li>
        <li>Lost or unattended items are the responsibility of the Tenant, and the Management is not liable for any such losses.</li>
    </ul>

    <h2>5. Termination and Eviction</h2>
    <p>Either party may terminate this agreement by providing a written notice of <span class="section-label">{{ $contract->notice_period }} days</span>. In cases of violation of the house rules or non-payment of rent, the Management has the right to terminate the contract and require the Tenant to vacate the premises immediately.</p>

    <h2>6. Renewal</h2>
    <p>The contract may be renewed based on mutual agreement. If either party wishes to renew, they must notify the other party at least <span class="section-label">{{ $contract->notice_period }} days</span> prior to the expiration of the contract.</p>

    <h2>7. Miscellaneous</h2>
    <p>The Tenant agrees to keep the premises clean and dispose of waste in the designated areas. Any damages to the property caused by the Tenant must be repaired at the Tenant’s expense. Any special terms or conditions, such as the payment of utilities or additional services, are outlined in the <span class="section-label">Special Terms Section</span>.</p>

    <p>By signing this contract, the Tenant acknowledges and agrees to abide by all terms and conditions outlined herein. The Management also commits to providing the Tenant with a safe and secure living environment.</p>

    <h2>Signatures</h2>
    <p><span class="section-label">Tenant’s Signature:</span> <span class="signature-line"></span></p>
    <p><span class="section-label">Date:</span> <span class="section-label">{{ now()->format('F j, Y') }}</span></p>

    <p><span class="section-label">Management’s Signature:</span> <span class="signature-line"></span></p>
    <p><span class="section-label">Date:</span> <span class="section-label">{{ now()->format('F j, Y') }}</span></p>

    <div class="footer">
        <p>Agreement created on {{ now()->format('F j, Y') }}.</p>
    </div>

</body>
</html>
