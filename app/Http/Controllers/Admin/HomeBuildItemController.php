<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBuildItem;
use Illuminate\Http\Request;

class HomeBuildItemController extends Controller
{
    public function index()
    {
        return view('admin.home-build.index', [
            'items' => HomeBuildItem::orderBy('sort')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.home-build.form', ['item' => new HomeBuildItem]);
    }

    public function store(Request $request)
    {
        HomeBuildItem::create($this->validated($request));

        return redirect()->route('admin.home-build.index')->with('ok', 'Homepage card added.');
    }

    public function edit(HomeBuildItem $homeBuildItem)
    {
        return view('admin.home-build.form', ['item' => $homeBuildItem]);
    }

    public function update(Request $request, HomeBuildItem $homeBuildItem)
    {
        $homeBuildItem->update($this->validated($request));

        return redirect()->route('admin.home-build.index')->with('ok', 'Homepage card updated.');
    }

    public function destroy(HomeBuildItem $homeBuildItem)
    {
        $homeBuildItem->delete();

        return redirect()->route('admin.home-build.index')->with('ok', 'Homepage card removed.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:500'],
            'url' => ['required', 'string', 'max:2048', 'regex:/\A(?:\/(?!\/)|https?:\/\/|#)[^\s]*\z/i'],
            'sort' => ['required', 'integer', 'min:0', 'max:65535'],
        ]);
    }
}
