<?php


namespace App\Services;


class Calculator
{
    private $differentDate;

    private $amount;

    private $term;

    private $rate;

    private $amortization_period;

    private $iad;

    private $start_date;

    private $payment_type;


    public function calculate(array $params)
    {
        foreach ($params as $key => $param) {
            $this->{$key} = $param;
        }

        $this->differentDate = $this->differentDate($this->iad);

        if ($this->payment_type === 1)
          $res = $this->interestOnlyLoanPayment();
        else
            $res =  $this->amortizedLoanPayment();

        return $res;
    }

    private function interestOnlyLoanPayment()
    {

        $percent = (($this->amount * ($this->rate / 100)) / 12);

        for ($i = 1; $i <= $this->term; $i ++)
        {
            if ($this->differentDate === $i || $this->differentDate < 1) {
                return  number_format($percent,2);
            }
        }

    }

    private function amortizedLoanPayment()
    {
        $previousBalance = $this->amount;
        $paymentTotal = ($this->amount * ($this->rate / 100) / 12) / (1 - (1 / (pow((1 + ($this->rate / 100) / 12), $this->amortization_period))));

        for ($i = 1; $i <= $this->amortization_period; $i++) {

            $paymentPercent  = (($previousBalance * ($this->rate / 100)) / 12);
            $paymentBalance  = ($paymentTotal - $paymentPercent);
            $previousBalance = ($previousBalance - $paymentBalance);

            if ($previousBalance < 0) {
                $previousBalance = 0;
            }

            if ($this->differentDate === $i || $this->differentDate < 1) {
                return number_format($paymentTotal,2);
            }
        }

    }

    private function differentDate($date){
        $startDate = new \DateTime("$date");
        $now = new \DateTime();

        if ($startDate >= $now){
            return -1;
        }

        return date_diff($now,$startDate,true)->m;
    }
}
