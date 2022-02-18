<div>
    <div class="px-4 space-y-4 mt-8">
        <form method="get">
            <input type="text" placeholder="Search repos" wire:model.laxy="handle" />
        </form>

        <div wire:loading>Searching repos...</div>
        <div wire:loading.remove>

            @if ($handle == "")
            <div class="text-gray-500 text-sm">
                Enter a handle to search for repos.
            </div>
            @else
            @endif
            @if($repos)
            <form action="/save-repos" method="POST" class="w-full">
                @csrf
                <input type="hidden" value="{{ $handle }}" name="handle" />
                <div class="">
                    <div>
                        @foreach($repos as $repo)
                        <div class="form-check">
                            <input type="checkbox" value="" name="repo_{{$repo->name}}">
                            <label for="repo_{{$repo->name}}">
                                {{ $repo->name }}
                            </label>
                        </div>
                        @endforeach

                    </div>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
            </form>
            @else
            <p>No repos found</p>
            @endif
        </div>
    </div>

</div>