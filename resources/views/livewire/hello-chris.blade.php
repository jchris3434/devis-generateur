<div>
    <div x-data="{
        plombierHours: @entangle('plombierHours'),
        maconHours: @entangle('maconHours'),
        electricienHours: @entangle('electricienHours'),
        plombierRate: {{ $plombierRate }},
        maconRate: {{ $maconRate }},
        electricienRate: {{ $electricienRate }},
        TVArate: {{ $TVArate }},
        
        plombierSubtotal() {
            return parseFloat(this.plombierHours || 0) * this.plombierRate;
        },
        maconSubtotal() {
            return parseFloat(this.maconHours || 0) * this.maconRate;
        },
        electricienSubtotal() {
            return parseFloat(this.electricienHours || 0) * this.electricienRate;
        },
        totalHT() {
            return this.plombierSubtotal() + this.maconSubtotal() + this.electricienSubtotal();
        },
        totalTTC() {
            return this.totalHT() * (1 + this.TVArate / 100);
        },
        formatNumber(number) {
            return number.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    }" class="calculator-container">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
        <style>
            * {
                font-family: 'Roboto', sans-serif;
            }

            .calculator-container {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .devisTitle {
                font-size: 2rem;
                color: #2c3e50;
                text-align: center;
                margin-bottom: 2rem;
                font-weight: 600;
                width: 100%;
            }

            .trade-card {
                background: #f8f9fa;
                padding: 1.5rem;
                border-radius: 8px;
                margin-bottom: 1rem;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                width: 40%;
                min-width: 300px;
            }

            label {
                font-weight: 500;
                color: #495057;
                display: block;
                margin-bottom: 0.5rem;
            }

            input[type="number"] {
                width: 100%;
                max-width: 200px;
                border: 2px solid #dee2e6;
                border-radius: 4px;
                padding: 0.5rem;
                font-size: 1rem;
                transition: border-color 0.2s;
            }

            input[type="number"]:focus {
                outline: none;
                border-color: #4dabf7;
                box-shadow: 0 0 0 3px rgba(77, 171, 247, 0.1);
            }

            p {
                color: #2b8a3e;
                font-size: 1.1rem;
                margin-top: 0.5rem;
                font-weight: 500;
            }

            h3 {
                color: #364fc7;
                margin: 0.5rem 0;
            }

            .total-section {
                background: #e7f5ff;
                border-top: 2px solid #4dabf7;
                margin-top: 2rem;
                padding: 1.5rem;
                width: 40%;
                min-width: 300px;
                border-radius: 8px;
                text-align: center;
            }

            .download-btn {
                margin-top: 2rem;
                background: #4c6ef5;
                color: white;
                border: none;
                padding: 1rem 2rem;
                border-radius: 8px;
                font-weight: 500;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                transition: background-color 0.2s;
            }

            .download-btn:hover {
                background: #364fc7;
            }

            .download-icon {
                width: 1.5rem;
                height: 1.5rem;
            }
        </style>

        <h2 class="devisTitle">Calculateur de devis</h2>

        <div class="trade-card">
            <label for="plombier">Plombier - Heures : </label>
            <input type="number" id="plombier" x-model="plombierHours" min="0" />
            <p>Plombier (<span x-text="plombierRate"></span>€/h) : <span x-text="formatNumber(plombierSubtotal())"></span>€</p>
        </div>

        <div class="trade-card">
            <label for="macon">Maçon - Heures : </label>
            <input type="number" id="macon" x-model="maconHours" min="0" />
            <p>Maçon (<span x-text="maconRate"></span>€/h) : <span x-text="formatNumber(maconSubtotal())"></span>€</p>
        </div>

        <div class="trade-card">
            <label for="electricien">Électricien - Heures : </label>
            <input type="number" id="electricien" x-model="electricienHours" min="0" />
            <p>Électricien (<span x-text="electricienRate"></span>€/h) : <span x-text="formatNumber(electricienSubtotal())"></span>€</p>
        </div>

        <div class="total-section">
            <h3>Total HT : <span x-text="formatNumber(totalHT())"></span>€</h3>
            <h3>TVA (<span x-text="TVArate"></span>%) : <span x-text="formatNumber(totalTTC() - totalHT())"></span>€</h3>
            <h3>Total TTC : <span x-text="formatNumber(totalTTC())"></span>€</h3>
        </div>

        <button wire:click="downloadPDF" class="download-btn">
            <svg xmlns="http://www.w3.org/2000/svg" class="download-icon" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            Télécharger le Devis PDF
        </button>
    </div>
</div>