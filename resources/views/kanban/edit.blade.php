@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Editar Tasca Kanban: {{ $task->code }}</h2>
    <p class="text-muted">Modifica els detalls del tiquet seleccionat.</p>

    {{-- Missatges d'error de validació --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulari que apunta a la ruta d'actualització (tasks.update) --}}
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- O PATCH. Utilitzem PUT com has definit a les rutes. --}}
        
        <div class="row">
            <div class="col-md-6">
                {{-- Codi del Tiquet --}}
                <div class="mb-3">
                    <label for="code" class="form-label">Codi de Tasca</label>
                    {{-- Pre-emplenem amb el valor antic o el valor actual de la tasca --}}
                    <input type="text" class="form-control" id="code" name="code" value="{{ old('code', $task->code) }}" required>
                </div>
            </div>
            <div class="col-md-6">
                {{-- Data de Previsió --}}
                <div class="mb-3">
                    <label for="due_date" class="form-label">Data de Previsió de Finalització</label>
                    {{-- Format de data necessari per a input type="date" (Y-m-d) --}}
                    <input type="date" class="form-control" id="due_date" name="due_date" 
                        value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}">
                </div>
            </div>
        </div>

        {{-- Estat (Status) --}}
        <div class="mb-3">
            <label for="status" class="form-label">Estat de la Tasca</label>
            <select class="form-select" id="status" name="status" required>
                <option value="ToDo" {{ old('status', $task->status) == 'ToDo' ? 'selected' : '' }}>ToDo</option>
                <option value="Doing" {{ old('status', $task->status) == 'Doing' ? 'selected' : '' }}>Doing</option>
                <option value="Done" {{ old('status', $task->status) == 'Done' ? 'selected' : '' }}>Done</option>
            </select>
        </div>

        {{-- Descripció --}}
        <div class="mb-3">
            <label for="description" class="form-label">Descripció</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6">
                {{-- Responsable --}}
                <div class="mb-3">
                    <label for="user_id" class="form-label">Responsable</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        {{-- Bucle per omplir amb els usuaris de la BDD --}}
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                {{-- Prioritat --}}
                <div class="mb-3">
                    <label for="priority_id" class="form-label">Prioritat</label>
                    <select class="form-select" id="priority_id" name="priority_id" required>
                        {{-- Bucle per omplir amb les prioritats de la BDD --}}
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}" {{ old('priority_id', $task->priority_id) == $priority->id ? 'selected' : '' }}>
                                {{ $priority->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <hr>
        <button type="submit" class="btn btn-success me-2">Guardar Canvis</button>
        <a href="{{ route('kanban.index') }}" class="btn btn-secondary">Cancel·lar</a>

    </form>
</div>
@endsection