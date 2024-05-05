<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemplatePostRequest;
use App\Http\Requests\TemplatePutRequest;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::all();

        return response()->json($templates);
    }


    public function update(TemplatePutRequest $request, $id)
    {
        $data = $request->all();

        $template = Template::findOrFail($id);
        $template->update($data);

        return response()->json($template);
    }

    public function destroy(Request $request, $id)
    {
        $template = Template::findOrFail($id);
        $template->delete();

        return response()->noContent();
    }
}
