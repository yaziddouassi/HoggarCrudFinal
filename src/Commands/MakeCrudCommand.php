<?php

namespace Hoggarcrud\Hoggar\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Hoggarcrud\Hoggar\Utils\TransformString;
use Hoggarcrud\Hoggar\Utils\CrudPart;
use Hoggarcrud\Hoggar\Models\Hoggarcrud;

class MakeCrudCommand extends Command
{
    protected $signature = 'hoggar:make-crud';
    protected $description = 'Create CRUD Hoggar';

    public function handle()
    {
      
        $model = $this->ask('Choose your Model ?');
        $middleware = $this->ask('Choose your Middleware ?');


        $transform = new TransformString();
        $crudPart = new CrudPart();

        $modelLink = $transform->transformLink($model);
        $modelUrl = $transform->transformUrl($model);

        $piece1 = $crudPart->getPiece1($model, $modelLink, $modelUrl);
        $piece2 = $crudPart->getPiece2($model, $modelLink, $modelUrl);
        $piece3 = $crudPart->getPiece3($model, $modelLink, $modelUrl);
        $piece4 = $crudPart->getPiece4($model, $middleware, $modelUrl);
        $piece5 = $crudPart->getPiece5($model, $modelLink, $modelUrl);

        $dossier = base_path("app/Http/Controllers/Hoggar/Crud/{$model}");
        $custom = "{$dossier}/Customs";

        if (File::exists($dossier)) {
            $this->error('❌ Le CRUD already exists.');
            return;
        }

        File::makeDirectory($dossier, 0755, true);
        File::makeDirectory($custom, 0755, true);

        File::put("{$dossier}/CreatorController.php", $piece1);
        File::put("{$dossier}/UpdatorController.php", $piece2);
        File::put("{$dossier}/ListingController.php", $piece3);
        File::put("{$custom}/Page1Controller.php", $piece5);
        File::append(base_path('routes/hoggar.php'), $piece4);

        $vueTarget = base_path("resources/js/Pages/HoggarPages/Crud/{$model}");
        File::copyDirectory(base_path('vendor/hoggarcrud/hoggar/Fichiers/CrudFiles'), $vueTarget);

        foreach (File::allFiles($vueTarget) as $file) {
            if ($file->getExtension() === 'txt') {
                File::move($file->getPathname(), $file->getPath() . '/' . str_replace('.txt', '.vue', $file->getFilename()));
            }
        }

        $crud = new Hoggarcrud();
        $crud->model = $model;
        $crud->label = $modelLink;
        $crud->route = '/admin/' . $modelUrl;
        $crud->icon = 'description';
        $crud->active = true;
        $crud->save();

        $this->info("✅ CRUD {$model} created with success !");
    }
}