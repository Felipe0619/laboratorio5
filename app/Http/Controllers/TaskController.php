<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todas las tareas del usuario autenticado
       $tasks = Task::where('user_id', Auth::id())->get();

        // Opción para obtener todas las tareas con usuarios asociados
        $tasks = Task::with('user')->get();
        $users = User::all();
        return view('tasks.index', ['tasks' => $tasks]);
        //return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
           'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'priority' => 'required|string',
        'completed' => 'required|boolean',
        ]);

        $task = new Task();
        $task->name = $validatedData['name'];
        $task->description = $validatedData['description'];
        $task->priority = $validatedData['priority'];
        $task->completed = $validatedData['completed'];
        $task->user_id = Auth::id(); // Asignar el ID del usuario autenticado

        $task->save();

        return redirect('/tasks')->with('success', 'Tarea creada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
{
    // Cargar el usuario asociado a la tarea
    $task->load('user');

    // Mostrar la vista con detalles de la tarea y el usuario
    return view('tasks.show', compact('task'));
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->name = $validatedData['name'];
        $task->description = $validatedData['description'];

        $task->save();

        return redirect('/tasks')->with('success', 'Tarea actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('/tasks')->with('success', 'Tarea eliminada correctamente.');
    }

    /**
     * Mark the specified task as complete.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function complete(Task $task)
    {
        // Marcar la tarea como completada (por ejemplo, actualizar el campo 'completed')
        $task->completed = true;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Tarea marcada como completada.');
    }
}
class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Obtener todos los usuarios

        return view('users.index', compact('users'));
    }
}