<?php


namespace Database\Seeders;


trait TraitImport
{

    public function truncate (string $tablename){
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \Illuminate\Support\Facades\DB::table($tablename)->truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function obtainMethodPayment (int $oldValue = null){

        return match ($oldValue){
            null => null,
            0 => 1,
            1 => 2,
            2 => 3,
            3 => 4,
            4 => 5
        };
    }

    public function obtainMime (string $extension):string{

        return match($extension){
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpeg', 'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf',
            'ppt', 'pptx' => 'application/vnd.ms-powerpoint',
            'txt' => 'text/plain',
        };

        dd($extension);
    }

    private function moveFiles (string $morph, string $carpeta){

        $carpetaDocumentos = public_path('storage/documento/'.$carpeta.'/');

        $documentos = $this->antiguoItem->documento;

        if (is_null($documentos)){
            $documentos = $this->antiguoItem->documentos;
        }

        foreach($documentos as $documento){

            try{

                $ruta = $carpetaDocumentos.$documento->documento;

                $nuevo = new Documento();
                $nuevo->documentable_type = $morph;
                $nuevo->documentable_id = $this->item->id;

                $nuevo->archivo = $documento->documento;
                $nuevo->nombre_original = $documento->documento;
                $nuevo->mime = mime_content_type($ruta);
                $nuevo->descripcion = $documento->descripcion;

                $nuevo->save();

            }
            catch (\Exception $exception){

                dump('No existe', $documento, $exception->getMessage());

            }



        }
    }

}
