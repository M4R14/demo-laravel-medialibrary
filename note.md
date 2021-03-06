# laravel-medialibrary

ผมใช้ php:7.4 และ Laravel:7 ในการสาธิต

เพื่อสาธิตให้เข้าใจง่าย ผมจะสร้างเว็บ Blog อย่างง่าย คือ สามารถ Post ข้อความและรูปได้ เริ่มจาก สร้าง migration Posts Table

```php
// class CreatePostsTable
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->text('content');
    $table->timestamps();
});
```

ติดตั้ง laravel-medialibrary

```sh
composer require "spatie/laravel-medialibrary:^8.0.0"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
php artisan migrate
```

เพิ่มความสามารถในการเก็บรูปใน Post Model ด้วย `implements Spatie\MediaLibrary\HasMedia` และ `use  Spatie\MediaLibrary\InteractsWithMedia`

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;
}
```

สร้าง UI สร้างสำหรับ เขียน Post และ Upload รูป

```php
// app/Http/Controllers/PostController.php

public function store(Request $request)
{
    $path = $request->file('images')->store('media');

    $post = new Post;
    $post->content = $request->content;
    $post->save();

    $post->addMedia($path)->toMediaCollection();

    return back();
}
```
เพิ่ม `public_path('media') => storage_path('app/media')` ใน links ที่ `config/filesystems.php`
```php
// config/filesystems.php

'links' => [
    public_path('storage') => storage_path('app/public'),
    public_path('media') => storage_path('app/media'),
],
```
จากนั้น `php artisan storage:link` เพื่อให้เข้าถึงไฟล์ได้ผ่าน public 

### REF
- [Laravel filesystem](https://laravel.com/docs/7.x/filesystem)
- [Install laravel-medialibrary](https://docs.spatie.be/laravel-medialibrary/v8/installation-setup/)

