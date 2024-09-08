<!-- resources/views/fraud-analysis/view.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Fraud Analysis - View</h2>

        <table class="table">
            <tr>
                <th>Company</th>
                <td>{{ $record->company->name }}</td>
            </tr>
            <tr>
                <th>Year</th>
                <td>{{ $record->year }}</td>
            </tr>
            <tr>
                <th>DSRI</th>
                <td>{{ $record->dsri }}</td>
            </tr>
            <tr>
                <th>GMI</th>
                <td>{{ $record->gmi }}</td>
            </tr>
            <tr>
                <th>AQI</th>
                <td>{{ $record->aqi }}</td>
            </tr>
            <tr>
                <th>SGI</th>
                <td>{{ $record->sgi }}</td>
            </tr>
            <tr>
                <th>DEPI</th>
                <td>{{ $record->depi }}</td>
            </tr>
            <tr>
                <th>SGAI</th>
                <td>{{ $record->sgai }}</td>
            </tr>
            <tr>
                <th>LVGI</th>
                <td>{{ $record->lvgi }}</td>
            </tr>
            <tr>
                <th>TATA</th>
                <td>{{ $record->tata }}</td>
            </tr>
            <tr>
                <th>Beneish M-Score</th>
                <td>{{ $record->beneish_m_score }}</td>
            </tr>
        </table>
    </div>
@endsection
