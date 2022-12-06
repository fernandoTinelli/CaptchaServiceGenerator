<?php

namespace App\Model;

use App\Entity\Captcha;
use App\Repository\CaptchaRepository;
use DateInterval;
use DateTime;
use DateTimeInterface;
use DateTimeZone;

class CaptchaModel
{
    private static string $permittedChars = '0123456789abcdefghijklmnopqrstuvwxyz';
    private static int $captchaLength = 5;
    private static int $captchaExpire = 5;

    private CaptchaRepository $repository;

    public function __construct(CaptchaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function generate(): Captcha
    {
        $code = substr(str_shuffle(CaptchaModel::$permittedChars), 0, CaptchaModel::$captchaLength);

        $captcha = new Captcha();
        $captcha->setAnswer($code);
        $captcha->setExpire(
            (new DateTime('now', new DateTimeZone('America/Sao_Paulo')))
                ->modify('+' . CaptchaModel::$captchaExpire . ' minutes')
        );

        // $this->repository->save($captcha, true);

        return $captcha;
    }

    public function validate(string $answer): bool
    {
        return true;
    }
}