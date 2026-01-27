<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFile\StoreRequest;
use App\Http\Requests\UserFile\UpdateRequest;
use App\Models\UserFile;
use Exception;

class UserFileController extends Controller
{
    public function index()
    {
        return $this->success();
    }

    public function store(StoreRequest $request)
    {
        try {
            $data            = $request->validated();
            $data['user_id'] = $request->user()->id;

            $model = new UserFile($data);
            $model->save();
            return $this->success();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $data  = $request->validated();
            $model = UserFile::find($id);
            if (!$model) {
                return $this->error(404, 'Not Found');
            }
            $model->update($data);
            return $this->success();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
    }
}
