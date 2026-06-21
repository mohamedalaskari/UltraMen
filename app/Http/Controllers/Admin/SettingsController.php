<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Services\ContentServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private const PAGES = ['home', 'about', 'contact', 'footer'];

    public function __construct(
        private readonly ContentServiceInterface $content
    ) {}

    public function index(Request $request, string $page = 'home')
    {
        if (!in_array($page, self::PAGES, true)) {
            abort(404);
        }

        return view('admin.settings.index', [
            'page'   => $page,
            'pages'  => self::PAGES,
            'fields' => $this->content->getPageFields($page),
        ]);
    }

    public function update(Request $request, string $page)
    {
        if (!in_array($page, self::PAGES, true)) {
            abort(404);
        }

        $this->content->savePage($page, $request->except('_token', '_method'), $request->allFiles());

        return redirect()->route('admin.settings.index', $page)
            ->with('success', __('admin_settings.saved'));
    }
}
