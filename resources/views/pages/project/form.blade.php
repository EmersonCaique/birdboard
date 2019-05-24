@csrf

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="title">Title</label>

    <div class="control">
        <input
                type="text"
                class="input bg-transparent border-none shadow rounded p-3 text-xs w-full {{ session('title') ? 'border-red' : '' }}"
                name="title"
                placeholder="My next awesome project"
                required
                value="{{ $project->title }}">
    </div>
</div>

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="description">Description</label>

    <div class="control">
            <textarea
                name="description"
                rows="10"
                class="textarea bg-transparent border-none shadow rounded p-3 text-xs w-full {{ session('title') ? 'border-red' : '' }}"
                placeholder="I should start learning piano."
                required>{{ $project->description }}</textarea>
    </div>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="button is-link mr-2">{{ $buttonText }}</button>

        <a href="" class="text-default">Cancel</a>
    </div>
</div>

{{-- @include ('errors') --}}