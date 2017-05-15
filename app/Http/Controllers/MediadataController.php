<?php

namespace App\Http\Controllers;

use App\Addons;
use App\Mediadata;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MediadataController extends ApiController
{


    public function index()
    {
        $data = Mediadata::all();
        if (!$data) {
            return $this->respondNotFound();
        } else {
            return $this->respondSuccessData($data);
        }

    }

    public function show($id)
    {
        $data = Mediadata::find($id);
        if (!$data) {
            return $this->respondNotFound();
        } else {
            return $this->respondSuccessData($data);
        }
    }

    public function destroy($id)
    {
        if ($result = Mediadata::find($id)) {
            Addons::removeMediaFile(sprintf('%s/%s/%s', $this->getMediaRoot(), $result->moviepath, $result->moviefilename));
            Addons::removeMediaFile(sprintf('%s/%s/%s', $this->getMediaRoot(), $result->imagepath, $result->imagefilename));
            Mediadata::destroy($id);
            return $this->respondSuccessDeleted();
        } else {
            return $this->respondNotFound();
        }
    }

    public function create(Request $request)
    {
        $data = new Mediadata();
        $data->moviepath = $request->moviepath;
        $data->moviefilename = $request->moviefilename;
        $data->imagepath = $request->imagepath;
        $data->imagefilename = $request->imagefilename;
        $data->nametitle = $request->nametitle;
        $data->datetitle = $request->datetitle;
        $data->durationtitle = $request->durationtitle;
        $data->cam_id = $request->cam_id;
        $data->framerate = $request->framerate;
        $data->bitrate = $request->bitrate;
        $data->size = $request->size;
        $data->datemovie = $request->datemovie;
        try {
            $data->save();
            return $this->respondSuccessCreated();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
    }

    public function mediasize()
    {
        $data = new Mediadata();
        return $this->respondSuccessData($data->size());
    }

    public function lastrecord()
    {
        $data = new Mediadata();
        return $this->respondSuccessData($data->lastrecord());
    }

    public function firstrecord()
    {
        $data = new Mediadata();
        return $this->respondSuccessData($data->firstrecord());
    }

    public function freespace()
    {
        return $this->respondSuccessData(Addons::getMediaSpaceFree());
    }

    public function upload(Request $request, $media)
    {

        $uploadpath = sprintf('%s/%s', env('MEDIA_UPLOAD_PATH'), $media);
        $fieldname = env('MEDIA_UPLOAD_FIELD');

        try {
            $file = $request->file($fieldname);
            $fileName = $file->getClientOriginalName();
            $request->file($fieldname)->move($uploadpath, $fileName);
        } catch (\Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respondSuccessUploaded();
    }

}
