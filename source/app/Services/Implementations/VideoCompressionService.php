<?php

namespace App\Services\Implementations;

use App\Services\Interfaces\IFileService;
use App\Services\Interfaces\IVideoCompressionService;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use  FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use FFMpeg\Format\ProgressListener\AbstractProgressListener;
use ProtoneMedia\LaravelFFMpeg\FFMpeg\ProgressListenerDecorator;

class VideoCompressionService implements IVideoCompressionService
{
    private $fileService;

    public function __construct(IFileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function compressVideo($video_file, $directory)
    {
        $isSuccessful = false;

        //$lowBitrateFormat = ()->setKiloBitrate(500);

        // $format = new X264();
        // $decoratedFormat = ProgressListenerDecorator::decorate($format);

        $file_name = $video_file->getClientOriginalName();
        $extension = $this->fileService->getExtension($file_name);
        $outputFileName = 'video' . '.' . $extension;

        $file_path = $directory . DIRECTORY_SEPARATOR . $outputFileName;

        FFMpeg::fromDisk('local')->open($video_file)
            ->export()
            ->toDisk('local')
            ->inFormat(new X264())
            ->resize(700, 500, ResizeFilter::RESIZEMODE_SCALE_HEIGHT)
            ->onProgress(function ($percentage) {
                $output = new \Symfony\Component\Console\Output\ConsoleOutput();
                $output->writeln($percentage);
            })
            ->save($file_path);


        return true;
    }
}
