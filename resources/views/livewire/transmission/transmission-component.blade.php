<div>
    <div class="mb-3 flex justify-between items-baseline">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="/" icon="home" />
            <flux:breadcrumbs.item href="/dashboard">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="/dashboard">Transmission</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:text>Last update -> <flux:link href="/dashboard">Apr 19, 2025 - 3:45 PM</flux:link>
        </flux:text>
    </div>
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-2xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-2xl bg-neutral-50 dark:bg-neutral-900  flex items-center justify-center">
                <div class="text-center space-y-4">
                    <h1 class="text-8xl font-bold" wire:transition.fade>{{ $provinceCount }}</h1>
                    <h3 class="text-2xl font-bold">Total Province</h3>
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-2xl bg-neutral-50 dark:bg-neutral-900 flex items-center justify-center">
                <div class="text-center space-y-4">
                    <h1 wire:transition class="text-8xl font-bold">{{ $municipalityCount }}</h1>
                    <h3 class="text-2xl font-bold">Total Municipality</h3>
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-2xl bg-neutral-50 dark:bg-neutral-900  flex items-center justify-center">
                <div class="text-center space-y-4">
                    <h1 wire:transition class="text-8xl font-bold">{{ $barangayCount }}</h1>
                    <h3 class="text-2xl font-bold">Total Barangay</h3>
                </div>
            </div>
        </div>

        <!-- Realtime data here -->
        <div>

            <div class="grid grid-cols-3 gap-4">

                <div class="col-span-1 ">
                    <div x-data="{ latestId: null, transmittedTime: null }" x-init="
            window.addEventListener('new-message-id', event => {
                latestId = event.detail.id;
                transmittedTime = 0;
                const interval = setInterval(() => {
                    transmittedTime++;
                }, 1000);
                setTimeout(() => {
                    latestId = null;
                    clearInterval(interval);
                }, 5000);
            });
        " class="relative h-full flex-1 overflow-hidden rounded-xl space-y-2">
                        @if ($stores)
                        @foreach ($stores as $store)
                        <div wire:transition.scale.origin.top wire:key="{{ $store->id }}"
                            x-data
                            :class="latestId === {{ $store->id }} ? 'bg-neutral-600' : 'bg-neutral-50 dark:bg-neutral-900'"
                            class="p-3  rounded-lg shadow-sm transition-all duration-500">
                            <h2 class="text-xl font-bold mb-2">{{ $store->name}}</h2>
                            <p class="text-sm mb-4">{{ $store->description }}</p>
                            <p x-show="latestId === {{ $store->id }}" class="text-sm text-gray-500">Transmitted <span x-text="transmittedTime"></span> sec ago</p>
                            <flux:button variant="danger" wire:click="deleteMessage({{ $store->id }})">Delete</flux:button>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-span-2 relative aspect-video overflow-hidden rounded-2xl bg-neutral-50 dark:bg-neutral-900  flex items-center justify-center">

                    <style>
                        #map {
                            position: relative;
                            width: 100%;
                            height: 100%;
                        }
                    </style>
                    <div wire:ignore id="map"></div>

                    <script>
                        mapboxgl.accessToken = '{{ env('MAPBOX_TOKEN') }}'; // Added missing semicolon
                        const map = new mapboxgl.Map({
                            container: 'map',
                            style: 'mapbox://styles/mapbox/dark-v10',
                            center: [121.7740, 12.8797],
                            zoom: 4,
                            projection: 'mercator',
                            maxBounds: [[112.0, 2.0], [136.0, 23.0]]
                        });

                        map.addControl(new mapboxgl.NavigationControl());
                    </script>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('new-message-id', function(event) {
            const alertContainer = document.createElement('div');
            alertContainer.className = 'fixed top-4 right-4 bg-green-500 text-white p-4 rounded-2xl shadow-lg transition-opacity duration-300 opacity-0';
            alertContainer.innerText = 'New data transmitted! Dashboard has been updated.';
            document.body.appendChild(alertContainer);

            // Play sound
            const audio = new Audio('/sound/beep.mp3');
            audio.play();

            setTimeout(() => {
                alertContainer.classList.add('opacity-100');
            }, 100); // Delay to ensure the transition effect

            setTimeout(() => {
                alertContainer.classList.remove('opacity-100');
                setTimeout(() => {
                    document.body.removeChild(alertContainer);
                }, 300); // Wait for the fade-out transition to complete
            }, 5000); // Display the alert for 5 seconds
        });
    </script>
</div>