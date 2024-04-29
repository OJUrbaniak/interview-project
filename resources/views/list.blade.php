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
    <h1 class="text-3xl pb-4">Properties</h1>
    <div class="space-y-4 rounded-lg">
{{--   If given more time, I'd seperate this item into it's own template     --}}
        @foreach($locations as $location)
            <div class="w-full p-3 flex flex-col max-w-sm rounded-lg overflow-hidden listing">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                    {{$location->property_name}}
                </label>
                <div class="space-y-2">
                    <div class="flex flex-row">
                        <div class="flex flex-row space-x-2 px-3 w-full">
                            <label class="block tracking-wide text-gray-700 text-xs font-bold">
                                Location: {{$location->location_name}}
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <div class="flex flex-row space-x-2 px-3 w-full">
                            <label class="block tracking-wide text-gray-700 text-xs font-bold">
                                Near beach
                            </label>
                            <input disabled type="checkbox" {{$location->near_beach ? 'checked' : ''}}>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <div class="flex flex-row space-x-2 px-3 w-full">
                            <label class="block tracking-wide text-gray-700 text-xs font-bold">
                                Accepts pets
                            </label>
                            <input disabled type="checkbox" {{$location->accepts_pets ? 'checked' : ''}}>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <div class="items-center flex flex-row space-x-2 px-3 w-full">
                            <label class="block tracking-wide text-gray-700 text-xs font-bold">
                                Beds
                            </label>
                            <input disabled type="text" value={{$location->beds}}>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <div class="items-center flex flex-row space-x-2 px-3 w-full">
                            <label class="block tracking-wide text-gray-700 text-xs font-bold">
                                Sleeps
                            </label>
                            <input disabled type="text" value={{$location->sleeps}}>
                        </div>
                    </div>
                    @if(isset($available))
                    <div class="flex flex-row">
                        <label class="bg-green-800 text-white block tracking-wide rounded-lg text-center space-x-2 px-3 w-full">
                            Available
                        </label>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <a href="{{url('')}}">Back</a>
    @if(isset($pages) && count($pages) > 1)
    <div class="flex flex-row space-x-3">
        <p>Pages: </p>
        @foreach($pages as $page)
        <a href="{{url("$source?page=$page")}}">{{$page}}</a>
        @endforeach
    </div>
    @endif
</div>
</body>
</html>
