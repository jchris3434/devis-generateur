<?php

namespace App\Livewire;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Computed;

class HelloChris extends Component
{
    public $plombierHours = 0;
    public $maconHours = 0;
    public $electricienHours = 0;

    // tarif horaire
    public $plombierRate = 20;
    public $maconRate = 15;
    public $electricienRate = 25;

    public $TVArate = 19.6;

    // miseen cache des résultats avec #[Computed]
    #[Computed]
    public function plombierSubtotal()
    {
        return floatval($this->plombierHours) * $this->plombierRate;
    }

    #[Computed]
    public function maconSubtotal()
    {
        return floatval($this->maconHours) * $this->maconRate;
    }

    #[Computed]
    public function electricienSubtotal()
    {
        return floatval($this->electricienHours) * $this->electricienRate;
    }

    #[Computed]
    public function totalHT()
    {
        return $this->plombierSubtotal() + $this->maconSubtotal() + $this->electricienSubtotal();
    }

    #[Computed]
    public function totalTTC()
    {
        return $this->totalHT() * (1 + $this->TVArate / 100);
    }

    public function downloadPDF()
    {
        $data = [
            'plombierHours' => $this->plombierHours,
            'maconHours' => $this->maconHours,
            'electricienHours' => $this->electricienHours,
            'plombierSubtotal' => $this->plombierSubtotal(),
            'maconSubtotal' => $this->maconSubtotal(),
            'electricienSubtotal' => $this->electricienSubtotal(),
            'totalHT' => $this->totalHT(),
            'TVArate' => $this->TVArate,
            'totalTTC' => $this->totalTTC(),
            'date' => now()->format('d/m/Y'),
        ];

        $pdf = PDF::loadView('pdf.devis', $data);
        
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'devis-' . now()->format('Y-m-d') . '.pdf');
    }

    public function render()
    {
        return view('livewire.hello-chris')->layout('components.layouts.simple');
    }
}