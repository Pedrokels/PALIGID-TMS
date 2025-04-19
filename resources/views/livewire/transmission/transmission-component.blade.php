<div>
    <div class="mb-3 flex justify-between items-baseline">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="/" icon="home" />
            <flux:breadcrumbs.item wire:navigate href="/dashboard">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item wire:navigate href="/dashboard">Transmission</flux:breadcrumbs.item>
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

            <div class="grid grid-cols-4 gap-4">

                <div class="col-span-2 ">
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
                            class="p-4  rounded-lg shadow-sm transition-all duration-500">
                            <h2 class="text-xl font-bold mb-2">{{ $store->name}}</h2>
                            <p class="text-sm mb-4">{{ $store->description }}</p>
                            <p x-show="latestId === {{ $store->id }}" class="text-sm text-gray-500">Transmitted <span x-text="transmittedTime"></span> sec ago</p>
                            <!-- <flux:button variant="danger" wire:click="deleteMessage({{ $store->id }})">Delete</flux:button> -->
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-span-2 h-[600px] overflow-hidden rounded-2xl bg-neutral-50 dark:bg-neutral-900  flex items-center justify-center">


                    <div style="  position: relative;
                            width: 100%;
                            height: 100%;" wire:ignore id="map"></div>

                    <script>
                        function initializeMap() {
                            mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';
                            const map = new mapboxgl.Map({
                                container: 'map',
                                style: 'mapbox://styles/paligid-2025/cm9nvzh8s002x01sp9ytfay72',
                                center: [121.7740, 12.8797],
                                zoom: 4,
                                projection: 'mercator',
                            });

                            map.addControl(new mapboxgl.NavigationControl());

                            map.on('load', function () {
                                // Load the GeoJSON data for Benguet
                                map.addSource('benguet', {
                                    'type': 'geojson',
                                    'data': '/geojson/BENGUET.geojson'
                                });

                                map.addLayer({
                                    'id': 'benguet-layer',
                                    'type': 'fill',
                                    'source': 'benguet',
                                    'layout': {},
                                    'paint': {
                                        'fill-color': '#888888',
                                        'fill-opacity': 0.5
                                    }
                                });

                                const benguetMarker = new mapboxgl.Marker()
                                    .setLngLat([120.5887, 16.6158])
                                    .setPopup(new mapboxgl.Popup({ offset: 25 }).setText('Benguet'))
                                    .addTo(map);

                                benguetMarker.getElement().addEventListener('click', () => {
                                    map.setPaintProperty('benguet-layer', 'fill-color', '#FF0000');
                                    map.fitBounds([
                                        [120.4, 16.4],
                                        [120.8, 16.8]
                                    ], {
                                        padding: 50,
                                        duration: 1000
                                    });
                                });

                                // Load the GeoJSON data for Biliran
                                map.addSource('biliran', {
                                    'type': 'geojson',
                                    'data': '/geojson/BILIRAN.geojson'
                                });

                                map.addLayer({
                                    'id': 'biliran-layer',
                                    'type': 'fill',
                                    'source': 'biliran',
                                    'layout': {},
                                    'paint': {
                                        'fill-color': '#888888',
                                        'fill-opacity': 0.5
                                    }
                                });

                                const biliranMarker = new mapboxgl.Marker()
                                    .setLngLat([124.5240, 11.4711])
                                    .setPopup(new mapboxgl.Popup({ offset: 25 }).setText('Biliran'))
                                    .addTo(map);

                                biliranMarker.getElement().addEventListener('click', () => {
                                    map.setPaintProperty('biliran-layer', 'fill-color', '#FF0000');
                                    map.fitBounds([
                                        [124.4, 11.3],
                                        [124.6, 11.6]
                                    ], {
                                        padding: 50,
                                        duration: 1000
                                    });
                                });

                                // Load the GeoJSON data for Sultan Kudarat
                                map.addSource('sultan_kudarat', {
                                    'type': 'geojson',
                                    'data': '/geojson/SULTAN_KUDARAT.geojson'
                                });

                                map.addLayer({
                                    'id': 'sultan-kudarat-layer',
                                    'type': 'fill',
                                    'source': 'sultan_kudarat',
                                    'layout': {},
                                    'paint': {
                                        'fill-color': '#888888',
                                        'fill-opacity': 0.5
                                    }
                                });

                                const sultanKudaratMarker = new mapboxgl.Marker()
                                    .setLngLat([124.3228, 6.6380])
                                    .setPopup(new mapboxgl.Popup({ offset: 25 }).setText('Sultan Kudarat'))
                                    .addTo(map);

                                sultanKudaratMarker.getElement().addEventListener('click', () => {
                                    map.setPaintProperty('sultan-kudarat-layer', 'fill-color', '#FF0000');
                                    map.fitBounds([
                                        [124.2, 6.5],
                                        [124.4, 6.7]
                                    ], {
                                        padding: 50,
                                        duration: 1000
                                    });
                                });
                            });
                        }

                        document.addEventListener('DOMContentLoaded', function () {
                            initializeMap();
                        });

                        document.addEventListener('livewire:navigated', function () {
                            initializeMap();
                        });
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