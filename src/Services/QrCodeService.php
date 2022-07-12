<?php

namespace App\Services;

use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Color\Color;
class QrCodeService
{
    /**
     * @var BuilderInterface
     */
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function qrcode($id)
    {
        $url = $_SERVER['SERVER_NAME'].'/challenge/'; // URL du challenge

        $result = $this->builder
            ->data($url.$id)
            ->size(200)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->ForegroundColor(new Color(random_int(0,255), random_int(0,255), random_int(0,255)))
            ->build()
        ;

        $namePng = 'qr_code_'.$id.'.png';

        $result->saveToFile(\dirname(__DIR__,2).'/public/assets/qr-code/'.$namePng);
       //$result->getDataUri() <- return l'uri directement
        return $result->getDataUri();
    }
}