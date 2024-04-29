<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Search</title>
</head>
<body>
    <div class="min-h-screen flex flex-col items-center justify-center space-y-2">
        <div class="search items-center justify-center p-4 rounded-lg">
            <h1 class="text-3xl text-center">Search</h1>
            <form
                name="search-for-property"
                id="search-for-property"
                class="max-w-lg space-y-4 p-4"
                method="post"
                action="{{url('search')}}"
            >
                @csrf
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="grid-location">
                        Location
                    </label>
                    <input name="location" class="form-control block w-full rounded-lg border-2 border border-gray-200"
                           id="grid-location" type="text" placeholder="Chester">
                </div>

                <div class="flex flex-row">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-near_beach">
                            Near the beach
                        </label>
                        <input
                            name="near_beach"
                            class="form-control w-full border-2 rounded border border-gray-200"
                            id="grid-near_beach" type="checkbox">
                    </div>
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-accepts-pets">
                            Accepts pets
                        </label>
                        <input
                            name="accepts-pets"
                            class="form-control w-full border-2 rounded border border-gray-200"
                            id="grid-accepts-pets" type="checkbox">
                    </div>
                </div>

                <div class="flex flex-row px-3 space-x-4">
                    <div>
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-sleeps_min">
                            Sleeps (minimum)
                        </label>
                        <input
                            name="sleeps_min"
                            class="form-control w-full border-2 rounded border border-gray-200"
                            id="grid-sleeps_min"
                            type="number">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-beds_min">
                            Beds (minimum)
                        </label>
                        <input
                            name="beds_min"
                            class="form-control w-full border-2 rounded border border-gray-200"
                            type="number"
                        >
                    </div>
                </div>

                <h1 class="px-3 block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Availability</h1>
                <div class="flex flex-row px-3 space-x-4">
                    <div>
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-availability_start">
                            From
                        </label>
                        <input
                            name="availability_start"
                            class="form-control w-full border-2 rounded border border-gray-200"
                            id="grid-availability_start"
                            type="date">
                    </div>
                    <div>
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-availability_end">
                            To
                        </label>
                        <input
                            name="availability_end"
                            class="form-control w-full border-2 rounded border border-gray-200"
                            id="grid-availability_end"
                            type="date">
                    </div>
                </div>
                <button name="submit" type='submit' class="block w-full bg-gray-900 text-white rounded-lg">Submit</button>
            </form>
            <a href="{{url('all')}}">
                <button name="all-properties" class="block w-full bg-gray-900 text-white rounded-lg">All properties</button>
            </a>
        </div>
    </div>
</body>
</html>
