<x-filament::page>
    <ul>
        @foreach($this->getActivities() as $activity)
            <li>
                <strong>{{ $activity->user->name }}</strong>
                {{ $activity->activity_details }}
                <small>({{ $activity->created_at->diffForHumans() }})</small>
            </li>
        @endforeach
    </ul>
</x-filament::page>
