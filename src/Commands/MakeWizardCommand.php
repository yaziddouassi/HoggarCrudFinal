<?php

namespace Hoggarcrud\Hoggar\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Hoggarcrud\Hoggar\Utils\TransformString;
use Hoggarcrud\Hoggar\Utils\WizardPart;
use Hoggarcrud\Hoggar\Models\Hoggarcrud;

class MakeWizardCommand extends Command
{
    protected $signature = 'hoggar:make-wizard';
    protected $description = 'Create CRUD Wizard Hoggar';

    public function handle()
    {
        $model = $this->ask('Choose your Model ?');
        $middleware = $this->ask('Choose your Middleware ?');

        $transform = new TransformString();
        $wizardPart = new WizardPart();

        $modelLink = $transform->transformLink($model);
        $modelUrl = $transform->transformUrl($model);

        $piece1 = $wizardPart->getPiece1($model, $modelLink, $modelUrl);
        $piece2 = $wizardPart->getPiece2($model, $modelLink, $modelUrl);
        $piece3 = $wizardPart->getPiece3($model, $modelLink, $modelUrl);
        $piece4 = $wizardPart->getPiece4($model, $middleware, $modelUrl);
        $piece5 = $wizardPart->getPiece5($model, $modelLink, $modelUrl);

        $baseDir = base_path("app/Http/Controllers/Hoggar/Crud/{$model}");
        $customDir = "{$baseDir}/Customs";

        if (File::exists($baseDir)) {
            $this->error('❌ CRUD already exists.');
            return;
        }

        File::makeDirectory($baseDir, 0755, true);
        File::makeDirectory($customDir, 0755, true);

        File::put("{$baseDir}/CreatorController.php", $piece1);
        File::put("{$baseDir}/UpdatorController.php", $piece2);
        File::put("{$baseDir}/ListingController.php", $piece3);
        File::put("{$customDir}/Page1Controller.php", $piece5);
        File::append(base_path('routes/hoggar.php'), $piece4);

        // Copie des fichiers Vue.js
        $sourcePath = base_path('vendor/hoggarcrud/hoggar/Fichiers/WizardFiles');
        $targetPath = base_path("resources/js/Pages/HoggarPages/Crud/{$model}");

        File::copyDirectory($sourcePath, $targetPath);

        foreach (File::allFiles($targetPath) as $file) {
            if ($file->getExtension() === 'txt') {
                $newPath = $file->getPath() . '/' . str_replace('.txt', '.vue', $file->getFilename());
                File::move($file->getPathname(), $newPath);
            }
        }

        // Ajout dans la table hoggarcrud
        $crud = new Hoggarcrud();
        $crud->model = $model;
        $crud->label = $modelLink;
        $crud->route = '/admin/' . $modelUrl;
        $crud->icon = 'description';
        $crud->active = true;
        $crud->save();

        $this->info("✅ CRUD Wizard {$model} is generated !");
    }
}