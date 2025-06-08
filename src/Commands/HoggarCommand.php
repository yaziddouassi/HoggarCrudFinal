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

        
$licenseKey = env('GUMROAD_LICENSE_KEY');

// Vérifie si la clé de licence est définie
if (empty($licenseKey)) {
    $this->error('❌ GUMROAD_LICENSE_KEY is not set in your environment file.');
    return Command::FAILURE;
}

$productId = 'iG5U7fLhrV5MXpZfeSQmxQ=='; // Remplacez par l'ID de votre produit Gumroad

// Vérification de la licence via l'API de Gumroad
$response = Http::asForm()->post('https://api.gumroad.com/v2/licenses/verify', [
    'product_id' => $productId,
    'license_key' => $licenseKey,
    'increment_uses_count' => true,
]);

$data = $response->json();

if (!isset($data['success']) || !$data['success']) {
    $this->error('❌ Invalid Key.');
    return Command::FAILURE;
}

$uses = $data['uses'] ?? 0;
$maxUses = $data['purchase']['max_uses'] ?? 2;

if ($uses > $maxUses) {
    $this->error('❌ Licence already used');
    return Command::FAILURE;
}
      
        // Continuer avec l’installation du package...


        
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




            $this->info("Package installed with succes.");
        } else {
            $this->warn("Le package already installed.");
        }
    }
}