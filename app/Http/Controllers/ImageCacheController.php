<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpseclib\Net\SFTP;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Cache;

class ImageCacheController extends Controller
{
	public function showFile($mediaId)
	{
		try {
			// Intenta obtener la imagen de la caché
			$cachedMedia = Cache::get('media.' . $mediaId);

			if ($cachedMedia) {
				$divideImg = explode("/", $cachedMedia->getPath());
				$mediaFile = $divideImg[1];
				return response()->file(storage_path('app/public/cached/' . $mediaFile));
			}

			// Si la imagen no está en caché, intenta descargarla del servidor SFTP
			$sftp = new SFTP('86.48.20.100');

			if (!$sftp->login('Administrator', 'KGvNU5J7bVKMAyJ9')) {
				abort(403, 'Autenticación SFTP fallida');
			}

			// Busca el archivo multimedia en la base de datos por su ID
			$media = Media::findOrFail($mediaId);
			$explodeMedia = explode(".", $media->file_name);
			$remoteFilePath = '/ftp/cpe/storage/app/public/' . $media->id . '/' . $media->file_name;

			$localFilePath = storage_path('app/public/cached/' . $media->file_name);

			if (!$sftp->get($remoteFilePath, $localFilePath)) {
				abort(404, 'Imagen no encontrada en el servidor SFTP');
			}

			// Almacena la imagen en la caché durante un período de tiempo (por ejemplo, 72 horas)
			Cache::put('media.' . $mediaId, $media, now()->addHours(72));

			// Muestra la imagen
			return response()->file($localFilePath);
			
		} catch (\Exception $e) {
			// Maneja las excepciones aquí, puedes personalizar este bloque según tus necesidades
			return response()->view('errors.404', [], 404);
		}
	}

}
