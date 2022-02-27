<div>
    <div class="px-4 space-y-4 mt-8">
        <form method="get">
            <input type="text" placeholder="Search videos" wire:model.laxy="handle" />
        </form>

        <div wire:loading>Searching videos...</div>
        <div wire:loading.remove>

            @if ($handle == "")
            <div class="text-gray-500 text-sm">
                Enter a handle to search for videos.
            </div>
            @endif


            @if($videos)
            <form action="/save-videos" method="POST" class="w-full">
                @csrf
                <input type="hidden" value="{{ $handle }}" name="handle" />
                <div class="">
                    <div>
                        @foreach($videos as $video)
                        <div class="form-check">
                            <input type="checkbox" value="" name="video_{{$video['contentDetails']['videoId']}}">
                            <label for="video_{{$video['contentDetails']['videoId']}}">
                                {{ $video['snippet']['title'] }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit">Submit</button>
            </form>
            @else
            <p>No videos found</p>
            @endif
        </div>
    </div>
</div>