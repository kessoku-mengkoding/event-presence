<div class="flex gap-8">
  <div class="h-16 w-16 rounded-full bg-black overflow-clip">
    <img src="{{ $image_path }}" alt="Profile Picture">
  </div>
  <div>
    <h1 class="text-2xl font-semibold">{{ $name }} <span class="text-slate-300">/</span> <span
        class="{{$title_color}}">{{ $title }}</span></h1>
    <p class="font-thin">{{ $description }}</p>
  </div>
</div>
