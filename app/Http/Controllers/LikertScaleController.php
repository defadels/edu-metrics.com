<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLikertScaleRequest;
use App\Http\Requests\UpdateLikertScaleRequest;
use App\Models\LikertScale;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LikertScaleController extends Controller
{
    public function index(): View
    {
        $scales = LikertScale::withCount('options', 'questions')
            ->latest()
            ->paginate(15);

        return view('dashboard.likert-scales.index', compact('scales'));
    }

    public function create(): View
    {
        return view('dashboard.likert-scales.create');
    }

    public function store(StoreLikertScaleRequest $request): RedirectResponse
    {
        $scale = LikertScale::create($request->validated());

        // Create options for the scale
        $minValue = $request->input('min_value');
        $maxValue = $request->input('max_value');
        $minLabel = $request->input('min_label');
        $maxLabel = $request->input('max_label');

        $options = [];
        $order = 0;
        for ($i = $minValue; $i <= $maxValue; $i++) {
            $label = $i === $minValue ? $minLabel : ($i === $maxValue ? $maxLabel : "Value {$i}");
            $options[] = [
                'likert_scale_id' => $scale->id,
                'value' => $i,
                'label' => $label,
                'order' => $order++,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $scale->options()->createMany($options);

        return redirect()->route('dashboard.likert-scales.index')
            ->with('success', 'Likert scale created successfully.');
    }

    public function show(LikertScale $likertScale): View
    {
        $likertScale->load('options');

        return view('dashboard.likert-scales.show', compact('likertScale'));
    }

    public function edit(LikertScale $likertScale): View
    {
        $likertScale->load('options');

        return view('dashboard.likert-scales.edit', compact('likertScale'));
    }

    public function update(UpdateLikertScaleRequest $request, LikertScale $likertScale): RedirectResponse
    {
        $likertScale->update($request->validated());

        return redirect()->route('dashboard.likert-scales.index')
            ->with('success', 'Likert scale updated successfully.');
    }

    public function destroy(LikertScale $likertScale): RedirectResponse
    {
        $likertScale->delete();

        return redirect()->route('dashboard.likert-scales.index')
            ->with('success', 'Likert scale deleted successfully.');
    }
}
