<?php

namespace App\Controller;

use App\Model\CaptchaModel;
use App\Utils\ImageToAudio;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TextToImage;

class CaptchaController extends AbstractController
{
    #[Route('/captcha/generate', name: 'app_teste')]
    public function index(CaptchaModel $captchaModel): Response
    {
        $captcha = $captchaModel->generate();

        $img = new TextToImage;
        $img->createImage($captcha->getAnswer());

        $img->showImage();

        return new Response($img->showImage(), 200, [
            'Content-Type' => 'image/png'
        ]);

        // $pathFile = $this->getParameter('kernel.project_dir') . "\public\audio\\" . $captcha->getId() . '.wav';
        // $pathFile = $this->getParameter('kernel.project_dir') . "\public\audio\\" . $captcha->getAnswer() . '.wav';
        // $audioCreated = ImageToAudio::convert(
        //     $captcha->getAnswer(),
        //     $pathFile
        // );

        // if ($audioCreated) {
        //     try {
        //         return $this->json([
        //             // 'id' => $captcha->getId(),
        //             'id' => '1',
        //             'img' => $img->getBase64()
        //         ]);
        //     } catch (\Throwable $th) {
        //         dd($th);

        //         return $this->json([
        //             'false'
        //         ]);
        //     }
        // }

        // return $this->json([
        //     'false'
        // ]);
    }
}
