<?php

namespace App\Utils;

class ImageToAudio
{
    private static int $SAFT48kHz16BitStereo = 39;
    private static int $SSFMCreateForWrite = 3;

    public static function convert(string $text, string $toFile): bool
    {
        try {
            $format = new \com('SAPI.SpAudioFormat');
            $format->Type = self::$SAFT48kHz16BitStereo;

            $data = new \com('SAPI.SpFileStream');
            $data->Format = $format;
            $data->Open($toFile, self::$SSFMCreateForWrite);
            
            $voice = new \com('SAPI.SpVoice');
            $voice->AudioOutputStream = $data;
            $voice->Rate = -2;
            $voice->Volume = 100;
            $voice->Speak(self::prepareText($text));
            
            $data->Close();
            
            return true;
        } catch (\Throwable $th) {

            // Delete temp file

            return false;
        }
    }

    private static function prepareText(string $text): string
    {
        $preparedText = "";

        for ($i = 0; $i < strlen($text); $i++) {
            if ($i+1 < strlen($text)) {
                $preparedText .= $text[$i] . " ";
            } else {
                $preparedText .= $text[$i];
            }
        }

        return $preparedText;
    }
}