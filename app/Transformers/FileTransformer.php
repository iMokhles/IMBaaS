<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($file)
    {
        return [
            'name' => $file->filename,
            'type' => $file->content_type,
            'size' => $file->size,
            'md5' => $file->md5,
            'ext' => $file->ext,
            'created_at' => $file->created_at,
            'updated_at' => $file->updated_at,
        ];
    }
}
