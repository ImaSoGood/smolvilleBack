<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isEmpty;

class ImageService
{
    protected $manager;
    protected $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    
    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Загрузка и обработка изображения
     */
    public function uploadAndResize($file, $eventType, $maxWidth = 1920, $maxHeight = 1080, $quality = 100)
    {
        try 
        {
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, $this->allowedExtensions))
                throw new \Exception('Недопустимый формат файла. Разрешены: ' . implode(', ', $this->allowedExtensions));

            $fileName = Str::uuid() . '.' . $extension;
            $directory = "images/{$eventType}";
            $fullDirectory = storage_path("app/public/{$directory}");
            if (!file_exists($fullDirectory)) 
                mkdir($fullDirectory, 0755, true);

            $image = $this->manager->read($file->getRealPath());
            $image->scaleDown($maxWidth, $maxHeight);// Изменяем размер с сохранением пропорций
            $fullPath = storage_path("app/public/{$directory}/{$fileName}");

            switch ($extension)
            {
                case 'png':
                    $image->toPng($quality)->save($fullPath);
                    break;
                case 'gif':
                    $image->toGif()->save($fullPath);
                    break;
                default:
                    $image->toJpeg($quality)->save($fullPath);
            }

            return "/storage/{$directory}/{$fileName}";
        } 
        catch (\Exception $e) 
        {
            Log::error('Ошибка обработки изображения: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Обновление пути к изображению в БД
     */
    public function updateImageInDatabase($eventId, $imagePath, $eventType)
    {
        try 
        {
            $model = $this->getModelByType($eventType);
            if (!$model)
                throw new \Exception("Неизвестный тип события: {$eventType}");

            $record = $model::find($eventId);
            if (!$record) 
                throw new \Exception("Запись с ID {$eventId} не найдена");

            // Удаляем старое изображение если оно существует
            if ($record->image_url) 
                $this->deleteOldImage($record->image_url);
            $record->image_url = $imagePath;
            return $record->save();
        } 
        catch (\Exception $e) 
        {
            Log::error('Ошибка обновления изображения в БД: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Удаление старого изображения
     */
    public function deleteOldImage($imagePath)
    {
        try 
        {
            // Убираем /storage/ из пути для работы с Storage
            $relativePath = str_replace('/storage/', '', $imagePath);    
            if (Storage::disk('public')->exists($relativePath)) 
                return Storage::disk('public')->delete($relativePath);
            
            return true;
        } 
        catch (\Exception $e) 
        {
            Log::warning('Не удалось удалить старое изображение: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Полная обработка изображения (загрузка + обновление в БД)
     */
    public function processImage($file, $eventType, $eventId)
    {
        $imagePath = $this->uploadAndResize($file, $eventType);
        
        if (!$imagePath) 
        {
            return [
                'success' => false,
                'message' => 'Ошибка при обработке изображения'
            ];
        }

        $updated = $this->updateImageInDatabase($eventId, $imagePath, $eventType);
        
        return [
            'success' => $updated,
            'image_path' => $imagePath,
            'message' => $updated ? 'Изображение успешно обновлено' : 'Ошибка при обновлении в БД'
        ];
    }

    /**
     * Получение модели по типу события
     */
    protected function getModelByType($type)
    {
        $models = [
            'event' => \App\Models\Event::class,
            'meet' => \App\Models\Meeting::class,
            'ad' => \App\Models\Ad::class,
            'voting' => \App\Models\Voting::class,
        ];

        return $models[$type] ?? null;
    }
}