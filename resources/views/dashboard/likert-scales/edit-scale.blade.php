@extends('layouts.dashboard')

@section('title', 'Likert Scale Details')
@section('page-title', 'Likert Scale Details')

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white rounded-lg shadow p-6 mb-4">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $likertScale->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Range: {{ $likertScale->min_value }} -
                        {{ $likertScale->max_value }}</p>
                </div>
                {{-- <div class="flex space-x-2">
                    <a href="{{ route('dashboard.likert-scales.edit', $likertScale) }}"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        Edit
                    </a>
                    <form action="{{ route('dashboard.likert-scales.destroy', $likertScale) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this scale?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </div> --}}
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Label</label>
                <p class="text-gray-900">{{ $likertScale->min_label }} - {{ $likertScale->max_label }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">


            <div class="flex justify-between items-start mb-4">


                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Scale Options
                        ({{ $likertScale->options->count() }})
                    </h4>
                </div>

                {{-- <div class="flex space-x-2">
                    <a href="{{ route('dashboard.likert-scales.edit', $likertScale) }}"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        Edit
                    </a>
                </div> --}}
            </div>

            @if ($likertScale->options->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Label</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <form method="POST" action="{{ route('dashboard.scale-option.update', $likertScale) }}">
                                @csrf
                                @method('PUT')
                                @foreach ($likertScale->options->sortBy('order') as $option)
                                    <input type="hidden" value="{{ $option->id }}" name="id" />

                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <input value="{{ $option->value }}" name="options[{{ $option->id }}][value]"
                                                class="w-full border border-gray-300 rounded-lg px-2 py-1" />
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <input value="{{ $option->label }}" name="options[{{ $option->id }}][label]"
                                                class="w-full border border-gray-300 rounded-lg px-2 py-1" />
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <input value="{{ $option->order }}" name="options[{{ $option->id }}][order]"
                                                class="w-full border border-gray-300 rounded-lg px-2 py-1" />
                                        </td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-sm text-gray-900">
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                            Update Data
                                        </button>
                                    </td>
                                </tr>

                            </form>
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No options in this scale yet.</p>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('dashboard.likert-scales.index') }}" class="text-blue-600 hover:text-blue-900">← Back to
                list</a>
        </div>
    </div>
@endsection
