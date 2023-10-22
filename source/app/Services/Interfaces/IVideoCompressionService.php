<?php

namespace App\Services\Interfaces;

interface IVideoCompressionService
{

    public function compressVideo($video_file, $directory);

}
