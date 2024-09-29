<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fraud Analysis Report - Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1, h2 {
            text-align: center;
        }

        .header {
            text-align: center;
            font-size: 16px;
            color: #333;
            padding-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-header {
            background-color: #6f42c1;
            color: white;
            padding: 8px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .highlight {
            color: green;
        }

        .warning {
            color: red;
        }

        .score {
            font-size: 24px;
            text-align: center;
            margin: 20px 0;
        }

        .interpretation {
            font-size: 14px;
            color: #444;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Financial Fraud Report</h1>

    <div class="header">
        <strong>Company Name:</strong> {{ $record->company->name }} <br>
        <strong>Recent Annual Report Year:</strong> {{ $record->year }}
    </div>

    <!-- Section 1: Financial Data -->
    <div class="section">
        <div class="section-header">Financial Data (in millions)</div>
        <table>
            <tr>
                <th></th>
                <th>{{ $financialDataCurrentYear->year }}</th>
                <th>{{ $financialDataPreviousYear->year }}</th>
            </tr>
            <tr>
                <td>Revenue</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->sales / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->sales / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>Cost of Goods Sold</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->cost_of_goods_sold / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->cost_of_goods_sold / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>SG&A Expenses</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->sga_expenses / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->sga_expenses / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>Depreciation</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->depreciation / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->depreciation / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>Total Assets</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->total_assets / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->total_assets / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>Accounts Receivables</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->account_receivables / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->account_receivables / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>Current Assets</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->current_assets / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->current_assets / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>Property, Plant, & Equipment</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->plant_property_equipment / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->plant_property_equipment / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>Current Liabilities</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->current_liabilities / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->current_liabilities / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>Total Liabilities</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->total_liabilities / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->total_liabilities / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>Long-Term Debt</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->long_term_debt / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->long_term_debt / 1000000, 2) }}</td>
            </tr>
            <tr>
                <td>Cash Flow from Operations</td>
                <td>Rp.{{ number_format($financialDataCurrentYear->cash_flow_operations / 1000000, 2) }}</td>
                <td>Rp.{{ number_format($financialDataPreviousYear->cash_flow_operations / 1000000, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- Section 2: Financial Ratios Indexes -->
    <div class="section">
        <div class="section-header">Financial Ratios Indexes</div>
        <table>
            <tr>
                <th>Ratio</th>
                <th>{{ $financialDataCurrentYear->year }}</th>
                <th>{{ $financialDataPreviousYear->year }}</th>
                <th>Index</th>
            </tr>
            <tr>
                <td>Day Sales in Receivables Index (DSRI)</td>
                <td>{{ number_format($record->dsri, 2) }}</td>
                <td>N/A</td>
                <td>{{ number_format($record->dsri, 2) }}</td>
            </tr>
            <tr>
                <td>Gross Margin Index (GMI)</td>
                <td>{{ number_format($record->gmi, 2) }}</td>
                <td>N/A</td>
                <td>{{ number_format($record->gmi, 2) }}</td>
            </tr>
            <tr>
                <td>Asset Quality Index (AQI)</td>
                <td>{{ number_format($record->aqi, 2) }}</td>
                <td>N/A</td>
                <td>{{ number_format($record->aqi, 2) }}</td>
            </tr>
            <tr>
                <td>Sales Growth Index (SGI)</td>
                <td>{{ number_format($record->sgi, 2) }}</td>
                <td>N/A</td>
                <td>{{ number_format($record->sgi, 2) }}</td>
            </tr>
            <tr>
                <td>Depreciation Index (DEPI)</td>
                <td>{{ number_format($record->depi, 2) }}</td>
                <td>N/A</td>
                <td>{{ number_format($record->depi, 2) }}</td>
            </tr>
            <tr>
                <td>SG&A Expenses Index (SGAI)</td>
                <td>{{ number_format($record->sgai, 2) }}</td>
                <td>N/A</td>
                <td>{{ number_format($record->sgai, 2) }}</td>
            </tr>
            <tr>
                <td>Leverage Index (LVGI)</td>
                <td>{{ number_format($record->lvgi, 2) }}</td>
                <td>N/A</td>
                <td>{{ number_format($record->lvgi, 2) }}</td>
            </tr>
            <tr>
                <td>Total Accruals to Total Assets (TATA)</td>
                <td>{{ number_format($record->tata, 2) }}</td>
                <td>N/A</td>
                <td>{{ number_format($record->tata, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- Beneish M Score -->
    <div class="score">
        <strong>Beneish M Score:</strong> 
        <span class="{{ $record->beneish_m_score > -2.22 ? 'warning' : 'highlight' }}">
            {{ number_format($record->beneish_m_score, 3) }}
        </span>
    </div>

    <!-- Interpretation Section -->
    <div class="interpretation">
        @if($record->beneish_m_score < -2.22)
            <span class="highlight">
                {{ $record->company->name }} is not likely to have manipulated their earnings.
            </span>
        @else
            <span class="warning">
                {{ $record->company->name }} is likely to have manipulated their earnings.
            </span>
        @endif
    </div>
</body>
</html>
