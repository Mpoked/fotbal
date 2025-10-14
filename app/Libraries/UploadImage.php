<?php

namespace App\Libraries;

class UploadImage
{
    public function uploadImage($file, string $directory = 'sigma/')
    {
        $uploadPath = FCPATH . $directory;

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = time() . '_' . $file->getRandomName();

        if (!$file->move($uploadPath, $newName)) {
            return [
                'success' => false,
                'error' => 'Přesun souboru selhal.'
            ];
        }

        // Vracíme rovnou URL
        $fileUrl = base_url($directory . $newName);

        return [
            'success' => true,
            'location' => $fileUrl
        ];
    }
}