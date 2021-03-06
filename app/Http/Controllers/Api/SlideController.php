<?php

namespace Zeropingheroes\Lanager\Http\Controllers\Api;

use Illuminate\Http\Request;
use Zeropingheroes\Lanager\Http\Controllers\Controller;
use Zeropingheroes\Lanager\Http\Resources\Slide as SlideResource;
use Zeropingheroes\Lanager\Lan;
use Zeropingheroes\Lanager\Slide;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Lan $lan
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Lan $lan)
    {
        $slides = $lan->slides()
            ->where('published', 1)
            ->orderBy('position')
            ->get();

        return SlideResource::collection($slides);
    }

    /**
     * Display the specified resource.
     *
     * @param Lan $lan
     * @param Slide $slide
     * @return SlideResource
     */
    public function show(Lan $lan, Slide $slide)
    {
        $this->authorize('view', $slide);

        // If the slide is accessed via the wrong LAN ID, show 404
        if ($slide->lan_id != $lan->id) {
            abort(404);
        }
        return new SlideResource($slide);
    }
}
