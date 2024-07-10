@extends('layouts.app')

@section('title', 'Crear Tarea')

@section('content')
    <div class="container">
        <h1>Crear Tarea</h1>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
                <label for="priority" class="form-label">Prioridad</label>
                <select class="form-control" id="priority" name="priority" required>
                    <option value="Baja">Baja</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="completed" class="form-label">Completada</label>
                <select class="form-control" id="completed" name="completed" required>
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
        </form>
    </div>
@endsection
