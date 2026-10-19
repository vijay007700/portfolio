<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

abstract class CrudController extends Controller
{
    protected string $modelClass;
    protected string $title;
    protected string $routeName;
    protected array $fields = [];
    protected array $rules = [];

    public function index()
    {
        $modelClass = $this->modelClass;
        $items = $modelClass::query()->latest('id')->paginate(20);
        return view('admin.crud.index', [
            'items' => $items,
            'title' => $this->title,
            'routeName' => $this->routeName,
            'fields' => $this->fields,
        ]);
    }

    public function create()
    {
        return view('admin.crud.form', [
            'item' => null,
            'title' => $this->title,
            'routeName' => $this->routeName,
            'fields' => $this->fields,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules());
        $data = $this->prepareData($request, $data);
        $modelClass = $this->modelClass;
        $modelClass::create($data);
        return redirect()->route("admin.{$this->routeName}.index")->with('success', "{$this->title} item created.");
    }

    public function edit(int $id)
    {
        $modelClass = $this->modelClass;
        $item = $modelClass::findOrFail($id);
        return view('admin.crud.form', [
            'item' => $item,
            'title' => $this->title,
            'routeName' => $this->routeName,
            'fields' => $this->fields,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $modelClass = $this->modelClass;
        $item = $modelClass::findOrFail($id);
        $data = $request->validate($this->validationRules($item));
        $data = $this->prepareData($request, $data, $item);
        $item->update($data);
        return redirect()->route("admin.{$this->routeName}.index")->with('success', "{$this->title} item updated.");
    }

    public function destroy(int $id)
    {
        $modelClass = $this->modelClass;
        $item = $modelClass::findOrFail($id);
        $item->delete();
        return back()->with('success', "{$this->title} item deleted.");
    }

    protected function prepareData(Request $request, array $data, ?Model $item = null): array
    {
        foreach ($this->fields as $name => $field) {
            $type = $field['type'] ?? 'text';

            if ($type === 'checkbox') {
                $data[$name] = $request->boolean($name);
            }

            if ($type === 'images') {
                if ($request->hasFile($name)) {
                    $paths = [];
                    foreach ($request->file($name) as $file) {
                        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
                        $file->move(public_path('uploads'), $filename);
                        $paths[] = 'uploads/'.$filename;
                    }
                    $data[$name] = $paths;
                } elseif ($item) {
                    unset($data[$name]);
                }
            }

            if ($type === 'image' && $request->hasFile($name)) {
                $file = $request->file($name);
                $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $filename);
                $data[$name] = 'uploads/'.$filename;
            } elseif ($type === 'image' && $item) {
                unset($data[$name]);
            }
        }

        if (array_key_exists('slug', $this->fields) && empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']).'-'.Str::lower(Str::random(5));
        }

        return $data;
    }

    protected function validationRules(?Model $item = null): array
    {
        $rules = $this->rules;

        if (array_key_exists('slug', $this->fields)) {
            $modelClass = $this->modelClass;
            $uniqueSlug = Rule::unique((new $modelClass())->getTable(), 'slug');
            if ($item) {
                $uniqueSlug->ignore($item->getKey());
            }
            $rules['slug'][] = $uniqueSlug;
        }

        return $rules;
    }
}
