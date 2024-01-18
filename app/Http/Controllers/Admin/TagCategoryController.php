<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTagCategoryRequest;
use App\Http\Requests\StoreTagCategoryRequest;
use App\Http\Requests\UpdateTagCategoryRequest;
use App\Models\TagCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TagCategoryController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('tag_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TagCategory::query()->select(sprintf('%s.*', (new TagCategory())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'tag_category_show';
                $editGate = 'tag_category_edit';
                $deleteGate = 'tag_category_delete';
                $crudRoutePart = 'tag-categories';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('comments', function ($row) {
                return $row->comments ? $row->comments : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.tagCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('tag_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tagCategories.create');
    }

    public function store(StoreTagCategoryRequest $request)
    {
        $tagCategory = TagCategory::create($request->all());

        return redirect()->route('admin.tag-categories.index');
    }

    public function edit(TagCategory $tagCategory)
    {
        abort_if(Gate::denies('tag_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tagCategories.edit', compact('tagCategory'));
    }

    public function update(UpdateTagCategoryRequest $request, TagCategory $tagCategory)
    {
        $tagCategory->update($request->all());

        return redirect()->route('admin.tag-categories.index');
    }

    public function show(TagCategory $tagCategory)
    {
        abort_if(Gate::denies('tag_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tagCategory->load('tagCategoryTags', 'tagCategoryResources');

        return view('admin.tagCategories.show', compact('tagCategory'));
    }

    public function destroy(TagCategory $tagCategory)
    {
        abort_if(Gate::denies('tag_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tagCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyTagCategoryRequest $request)
    {
        TagCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
