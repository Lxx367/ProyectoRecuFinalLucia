<?php

namespace App\Models;

use Symfony\Component\Serializer\Annotation\SerializedName;

class PaymentDTO
{
    #[SerializedName("payment_type")]
    public string $paymentType;

    public string $number;
}
