<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    public $name;
    public $search;
    public $edittodoID;
    public $editTodoName;

    protected $rules = [
        'name' => 'required|min:3|max:50',
        'editTodoName' => 'required|min:3|max:50', // Validation for editing
    ];

    public function Create()
    {
        $this->validate(['name' => 'required|min:3|max:50']);
        Todo::create(['name' => $this->name, 'completed' => false]);
        $this->reset('name');
        session()->flash('success', 'Record Created Successfully!');
    }

    public function delete($todoID)
    {
        Todo::find($todoID)->delete();
        session()->flash('success', 'Record Deleted Successfully!');
    }

    public function edit($todoID)
    {
        $this->edittodoID = $todoID;
        $this->editTodoName = Todo::find($todoID)->name;
    }

    public function update()
    {
        $this->validate(['editTodoName' => 'required|min:3|max:50']);
        $todo = Todo::find($this->edittodoID);
        $todo->name = $this->editTodoName;
        $todo->save();
        $this->reset(['edittodoID', 'editTodoName']);
        session()->flash('success', 'Todo Updated Successfully!');
    }

    public function toggle($todoID)
    {
        $todo = Todo::find($todoID);
        $todo->completed = !$todo->completed;
        $todo->save();
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Todo::latest()->where('name', 'LIKE', "%{$this->search}%")->paginate(5)
        ]);
    }
}
