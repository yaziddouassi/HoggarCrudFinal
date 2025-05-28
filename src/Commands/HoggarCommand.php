<?php

namespace Hoggarcrud\Hoggar\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class HoggarCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hoggar:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hoggar Installation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $sourcePath = base_path('vendor/hoggarcrud/hoggar/Fichiers/PhpFiles');
        $sourcePath2 = base_path('vendor/hoggarcrud/hoggar/Fichiers/RouteFiles/devhoggar.php');
        $sourcePath3 = base_path('vendor/hoggarcrud/hoggar/Fichiers/RouteFiles/hoggar.php');

        $destinationPath = base_path('app/Http/Controllers/Hoggar');
        $destinationPath2 = base_path('routes/devhoggar.php');
        $destinationPath3 = base_path('routes/hoggar.php');
        // Si le dossier N'EXISTE PAS, on procède à l'installation
        if (!File::exists($destinationPath)) {
          
            if (!File::exists($sourcePath)) {
                $this->error("Le dossier source n'existe pas : $sourcePath");
                return;
            }

           
            File::copyDirectory($sourcePath, $destinationPath);

            if (File::exists($sourcePath2)) {
                File::copy($sourcePath2, $destinationPath2); // Crée destination.txt s'il n'existe pas
            }

            if (File::exists($sourcePath3)) {
                File::copy($sourcePath3, $destinationPath3); // Crée destination.txt s'il n'existe pas
            }


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////


            $sourcePath4 = base_path('vendor/hoggarcrud/hoggar/Fichiers/HoggarLib1');
       
            $temp4 = 'resources/js/HoggarLibs'  ;
    
            $directory4 = base_path($temp4);
    
            File::copyDirectory($sourcePath4, $directory4);
    
            if (!File::exists($directory4)) {
                return response()->json(['error' => 'Dossier non trouvé.'], 404);
            }
        
            // Récupère tous les fichiers (même dans les sous-dossiers)
            $files4 = File::allFiles($directory4);
        
            foreach ($files4 as $file4) {
                if ($file4->getExtension() === 'txt') {
                    // Nouveau nom avec extension .vue
                    $newFileName4 = str_replace('.txt', '.vue', $file4->getFilename());
        
                    // Nouveau chemin complet
                    $newFilePath4 = $file4->getPath() . '/' . $newFileName4;
        
                    // Renommer le fichier
                    File::move($file4->getPathname(), $newFilePath4);
                }
            }


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////

            $sourcePath5 = base_path('vendor/hoggarcrud/hoggar/Fichiers/HoggarPage1');
       
            $temp5 = 'resources/js/Pages/HoggarPages' ;

    
            $directory5 = base_path($temp5);
    
            File::copyDirectory($sourcePath5, $directory5);
    
            if (!File::exists($directory5)) {
                return response()->json(['error' => 'Dossier non trouvé.'], 404);
            }
        
            // Récupère tous les fichiers (même dans les sous-dossiers)
            $files5 = File::allFiles($directory5);
        
            foreach ($files5 as $file5) {
                if ($file5->getExtension() === 'txt') {
                    // Nouveau nom avec extension .vue
                    $newFileName5 = str_replace('.txt', '.vue', $file5->getFilename());
        
                    // Nouveau chemin complet
                    $newFilePath5 = $file5->getPath() . '/' . $newFileName5;
        
                    // Renommer le fichier
                    File::move($file5->getPathname(), $newFilePath5);
                }
            }


            ////////////////////////////////////////////////////////////////////////////////////////////
            ///////////////////////////////////////////////////////////////////////////////////////////





            $filePath = base_path('routes/web.php');
            $content = file_get_contents($filePath);

                if (!str_contains($content, "require __DIR__.'/hoggar.php';")) {
                     $linesToAdd = <<<PHP

                      require __DIR__.'/hoggar.php';
                      require __DIR__.'/devhoggar.php';

                      PHP;

             file_put_contents($filePath, $linesToAdd, FILE_APPEND);
             }




            $this->info("Package installé avec succès.");
        } else {
            $this->warn("Le package est déjà installé.");
        }
    }
}