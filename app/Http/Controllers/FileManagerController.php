<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Traits\FileManager;
use App\Traits\UtilTrait;
use File;

class FileManagerController extends Controller
{

    use FileManager;
    use UtilTrait;
    public function index()
    {
        $file_mng_records = \App\FileManager::all();
        $recent_files = \App\FileManager::orderBy('created_at', 'desc')->limit(3)->get();

        $house_images = $this->getFiles('houseImages', $file_mng_records);
        $agency_files = $this->getFiles('agencyDoc', $file_mng_records);
        $tenant_files = $this->getFiles('tenantContracts', $file_mng_records);
        $landlord_files = $this->getFiles('landlordContracts', $file_mng_records);
        $recent_files = $this->getFiles('recent_files', $recent_files);
        $data['recent_files'] = $recent_files;
        $data['house_imgs'] = $house_images;
        $data['agency_files'] = $agency_files;
        $data['tenant_files'] = $tenant_files;
        $data['landlord_files'] = $landlord_files;
        // return response()->json($recent_files);
        return view('filemanager.index', $data);
    }
    public function recent()
    {
        $file_mng_records = \App\FileManager::all();
        $recent_files = \App\FileManager::orderBy('created_at', 'desc')->limit(9)->get();

        $house_images = $this->getFiles('houseImages', $file_mng_records);
        $agency_files = $this->getFiles('agencyDoc', $file_mng_records);
        $tenant_files = $this->getFiles('tenantContracts', $file_mng_records);
        $landlord_files = $this->getFiles('landlordContracts', $file_mng_records);
        $recent_files = $this->getFiles('recent_files', $recent_files);
        $data['recent_files'] = $recent_files;
        $data['house_imgs'] = $house_images;
         $data['agency_files'] = $agency_files;
        $data['tenant_files'] = $tenant_files;
        $data['landlord_files'] = $landlord_files;
        // return response()->json($recent_files);
        return view('filemanager.recent', $data);
    }
    public function images()
    {
        $file_mng_records = \App\FileManager::all();
        // $recent_files = \App\Filemanager::orderBy('created_at', 'desc')->limit(9)->get();

        $house_images = $this->getFiles('houseImages', $file_mng_records);
        // $tenant_files = $this->getFiles('tenantContracts', $file_mng_records);
        // $landlord_files = $this->getFiles('landlordContracts', $file_mng_records);
        // $recent_files = $this->getFiles('recent_files', $recent_files);
        // $data['recent_files'] = $recent_files;
        $data['house_imgs'] = $house_images;
        // $data['tenant_files'] = $tenant_files;
        // $data['landlord_files'] = $landlord_files;
        // return response()->json($recent_files);
        return view('filemanager.images', $data);
    }
        public function store(Request $request)
    {
        $request->validate([
            'filenames' => 'nullable',
            'filenames.*' => 'mimes:doc,pdf,docx,zip,jpeg,png,PNG,JPG,jpg',
        ]);
        $filemanager = new FileManager();
        $files = $request->filenames;
        if (count($files) > 0) {
            $response = $this->uploadFiles($files, 'houseImages', $house->id);
        }
         return back()->with('success', 'File has been added successfully the system');
    }
    public function contract()
    {
        $file_mng_records = \App\FileManager::all();
        // $recent_files = \App\Filemanager::orderBy('created_at', 'desc')->limit(9)->get();

        // $house_images = $this->getFiles('houseImages', $file_mng_records);
        $tenant_files = $this->getFiles('tenantContracts', $file_mng_records);
        $landlord_files = $this->getFiles('landlordContracts', $file_mng_records);
        // $recent_files = $this->getFiles('recent_files', $recent_files);
        // $data['recent_files'] = $recent_files;
        // $data['house_imgs'] = $house_images;
        $data['tenant_files'] = $tenant_files;
        $data['landlord_files'] = $landlord_files;
        // return response()->json($recent_files);
        return view('filemanager.contract', $data);
    }
     public function documents()
    {
        $file_mng_records = \App\FileManager::all();
        // $recent_files = \App\Filemanager::orderBy('created_at', 'desc')->limit(9)->get();

        // $house_images = $this->getFiles('houseImages', $file_mng_records);
        $agency_files = $this->getFiles('agencyDoc', $file_mng_records);
        // $landlord_files = $this->getFiles('landlordContracts', $file_mng_records);
        // $recent_files = $this->getFiles('recent_files', $recent_files);
        // $data['recent_files'] = $recent_files;
        // $data['house_imgs'] = $house_images;
        $data['agency_files'] = $agency_files;
        // $data['landlord_files'] = $landlord_files;
        // return response()->json($recent_files);
        return view('filemanager.documents', $data);
    }

    // public function download(Request $request)
    // {
    //     //PDF file is stored under project/public/download/info.pdf
    //     // $filename = $request->file;
    //     $filename = 'contract.png';
    //     $file = public_path() . "rms/storage/app/filemanager/contract.png";

    //     $headers = array(
    //         'Content-Type: application/png',
    //     );

    //     return Response::download($file, $filename, $headers);
    // }
    public function delete_file(FileRequest $request)
    {
      
        //PDF file is stored under project/public/download/info.pdf
        // $filename = $request->file;

        $file = \App\FileManager::findOrFail($request->id);
        $file_path = storage_path('/app/filemanager/' . $request->file);

        $json_files = json_decode($file->filename);
        $haystack = $json_files;
        //dd([$request->id,$request->file,$json_files,count($haystack)]);
        if (($key = array_search($request->file, $haystack)) !== FALSE) {
          unset($haystack[$key]);
        }

        $found = 'found';
        // }

        if (count($haystack) > 0) {
            $file->update([
                'filename' => json_encode($haystack),
            ]);
            $found = 'data';
        } else {
            $found = 'no data';
            $file->delete();
        }
        // dd($found);

        // if ($file->count($json_files) === 0) {
        //     $file->delete();
        // }

        if (File::exists($file_path)) {
            unlink($file_path);
        }
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Files Deleted',
            'more_info' => 'n/a',
        ]);

        // $filee = \App\Filemanager::findOrFail($request->id);
        // dd([$request->file, $json_files, $found]);

        return back()->with('success', 'File successfully deleted');

    }

}
