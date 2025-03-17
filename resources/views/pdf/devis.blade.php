<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Devis</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .date {
            text-align: right;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
        }
        .section {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .total-section {
            margin-top: 30px;
            padding: 15px;
            background: #e7f5ff;
            border-radius: 5px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px solid #dee2e6;
        }
        .total {
            font-weight: bold;
            color: #364fc7;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DEVIS</h1>
    </div>

    <div class="date">
        Date: {{ $date }}
    </div>

    <div class="section">
        <div class="row">
            <span>Plombier ({{ $plombierHours }} heures)</span>
            <span>{{ number_format($plombierSubtotal, 2) }}€</span>
        </div>
        <div class="row">
            <span>Maçon ({{ $maconHours }} heures)</span>
            <span>{{ number_format($maconSubtotal, 2) }}€</span>
        </div>
        <div class="row">
            <span>Électricien ({{ $electricienHours }} heures)</span>
            <span>{{ number_format($electricienSubtotal, 2) }}€</span>
        </div>
    </div>

    <div class="total-section">
        <div class="row">
            <span>Total HT</span>
            <span>{{ number_format($totalHT, 2) }}€</span>
        </div>
        <div class="row">
            <span>TVA ({{ $TVArate }}%)</span>
            <span>{{ number_format($totalTTC - $totalHT, 2) }}€</span>
        </div>
        <div class="row total">
            <span>Total TTC</span>
            <span>{{ number_format($totalTTC, 2) }}€</span>
        </div>
    </div>

    <div style="margin-top: 50px; font-size: 12px; text-align: center;">
        <p>Ce devis est valable 30 jours à compter de sa date d'émission.</p>
    </div>
</body>
</html>
