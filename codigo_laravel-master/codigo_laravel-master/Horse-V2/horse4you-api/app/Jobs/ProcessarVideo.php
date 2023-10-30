<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\PostImage;
use FFMpeg\Filters\Video\VideoFilters;
use Illuminate\Support\Facades\Storage;
use FFMpeg;


class ProcessarVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postimageId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $postimage)
    {
        $this->postimageId = $postimage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $postimage = PostImage::find($this->postimageId);
        $path = $postimage->imageSemCaminho;
        $parteName = str_replace('imagens/posts/originais/', '',$path);
        $caminho =  'public/'.$path;

        FFMpeg::fromDisk('local')
        ->open($caminho)
        ->export()
        ->resize(400,1280, 'height')
        ->toDisk('publicVideo')
        ->inFormat(new \FFMpeg\Format\Video\X264)
        ->save($parteName);

        $existe = __DIR__.'/../../storage/app/public/'.$path;
        $existe1 = __DIR__.'/../../storage/app/public/imagens/posts/'.$parteName;
        $i = true;
        while($i){
            if(file_exists($existe1)){
                $i = false;
            }
        }

        $original = filesize($existe);
        $redimencionado = filesize($existe1);

        if($original > $redimencionado){
            $postimage->image = $caminho;
            $postimage->save();
        }
    }
}
