<?php

namespace App\Http\Controllers;

use App\Models\LinkClick;
use App\Models\LinkGroup;
use Illuminate\Http\Request;

class LinkGroupController extends Controller
{


    public function index()
    {
        $linkGroups = LinkGroup::orderBy("created_at", "desc")->paginate(10);
        return view("link-group.index", compact("linkGroups"));
    }


    public function show(LinkGroup $linkGroup)
    {
        $linkGroup->load(['links.denomination', 'links.link_type']);

        $linkIds = $linkGroup->links->pluck('id');

        $totalClicks = LinkClick::whereIn('link_id', $linkIds)->count();

        $mobileClicks = LinkClick::whereIn('link_id', $linkIds)
            ->where('device_type', 'mobile')
            ->count();

        $desktopClicks = LinkClick::whereIn('link_id', $linkIds)
            ->where('device_type', 'desktop')
            ->count();

        $tabletClicks = LinkClick::whereIn('link_id', $linkIds)
            ->where('device_type', 'tablet')
            ->count();

        // Dynamic layout decision (optional)
        $layout = auth()->user()?->role === 'admin' ? 'layouts.admin' : 'layouts.user';

        return view('link-group.show', compact(
            'linkGroup',
            'totalClicks',
            'mobileClicks',
            'desktopClicks',
            'tabletClicks',
            'layout'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LinkGroup $linkGroup)
    {
        return view('link-group.edit', [
            'linkGroup' => $linkGroup,
            'layout' => auth()->user()->role=='admin' ? 'layouts.admin' : 'layouts.user',
        ]);
    }

    public function update(Request $request, LinkGroup $linkGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'original_url' => 'required|url',
        ]);

        $linkGroup->update($validated);
        $linkGroup->links()->each(function ($link) use ($validated) {
            $link->update([
                'name' => $validated['name'],
                'original_url' => $validated['original_url'],
            ]);
        });
        // $linkGroup->links()->syncOriginal();

        return redirect()->route('link-group.edit', $linkGroup)->with('success', 'Link group updated successfully.');
    }


}
