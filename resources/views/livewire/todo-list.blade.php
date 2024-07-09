<div>
   @include('livewire.include.create todo-box')
   @include('livewire.include.search-box')
    
    <div id="todos-list">
      @foreach ($todos as $todo)
      @include('livewire.include.todo-card')
          
      @endforeach

        <div class="my-2">
            {{$todos->links()}}
        </div>
    </div>
</div>
