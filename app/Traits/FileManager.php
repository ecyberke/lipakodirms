<?php
namespace App\Traits;

// use App\;
use Illuminate\Support\Facades\Storage;
trait FileManager
{
    public function uploadFiles($files, $type, $type_id)
    {
        // $fls = [];
        foreach ($files as $file) {
            $fl_name = time() . '_' . $this->RandomString() . '.' . $file->getClientOriginalExtension();
            // $file->move(public_path() . '/filemanager/', $name);
            \Storage::disk('local')->putFileAs('filemanager/', $file, $fl_name);
            $data[] = $fl_name;
        }
        \App\FileManager::create([
            'type' => $type,
            'type_id' => $type_id,
            'filename' => json_encode($data),
        ]);

        return json_encode($data);
    }
   public function uploadFile($files, $type, $type_id)
    {
        // $fls = [];
        // foreach ($files as $file) {
            $fl_name = time() . '_' . $this->RandomString() . '.' . $files->getClientOriginalExtension();
            \Storage::disk('local')->putFileAs('filemanager/', $files, $fl_name);
            $data[] = $fl_name;
        // }
        \App\FileManager::create([
            'type' => $type,
            'type_id' => $type_id,
            'filename' => json_encode($data),
        ]);

        return json_encode($data);
    }
    public function uploadFileContracts($files, $type)
    {
        // $fls = [];
        // foreach ($files as $file) {
            $fl_name = time() . '_' . $this->RandomString() . '.' . $files->getClientOriginalExtension();
            \Storage::disk('local')->putFileAs('filemanager/', $files, $fl_name);
            $data[] = $fl_name;
        // }
        \App\FileManager::create([
            'type' => $type,
            'type_id' => 'Agency',
            'filename' => json_encode($data),
        ]);

        return json_encode($data);
    }

    public function getFiles($typ, $records)
    {
        if ($typ === 'recent_files') {
            $record = $records;
        } else {
            $record = $records->filter(function ($value, $key) use ($typ) {
                return $value->type === $typ;
            });
        }
        $recordss = [];
        foreach ($record as $rc) {
            if ($rc['type'] !== 'houseImages') {
                $rc['image_location'] = 'contract.png';
            }
            $rc['filename'] = json_decode($rc['filename']);
            $rc['details'] = $this->getModelData($rc['type_id'], $rc['type']);
            if($rc['details']){
                array_push($recordss,$rc);
            }
        }
        return $recordss;

    }

    private function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 5; $i++) {
            $randstring .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randstring;
    }

    private function getModelData($id, $model)
    {

        switch ($model) {
            case "houseImages":
                return \App\House::find($id);
                case "agencyDoc":
                return \App\FileManager::find($id);
            case "tenantContracts":
                return \App\Tenant::find($id);
            case "landlordContracts":
                return \App\Landlord::where('id', $id)->first();
            default:
                return 'null';
        }
    }
}
