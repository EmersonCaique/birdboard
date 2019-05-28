@can('manage', $project)
<div class="card flex flex-col justify-between mt-2">
    <div class="py-2">
        <h3 class="text-2xl mb-5 -ml-5 border-l-4 border-blue pl-4">
            Invite
        </h3>

            <form method="POST" action="{{ route('project.invitations', ['project' => $project->id ]) }}">
                @csrf
                <input type="email" name="email" class="w-full shadow-md py-2 pl-3 rounded"
                    placeholder="Email adress" required>

                <div class="w-full text-right">
                    <button type="submit" class="button mt-3">Invite</button>
                </div>
            </form>
        @include('pages.error', ['bag' => 'invitations'])
    </div>
</div>
@endcan
