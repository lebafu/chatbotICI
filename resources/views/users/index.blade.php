<x-app-layout>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row justify-content-center">
            @livewire('index-usuarios')   
        </div>
    </div>

</x-app-layout>