@extends('layouts.app')

@section('content')

<div class="container py-4">
<h2>Crear Nova Tasca Kanban</h2>
<p class="text-muted">Introdueix tots els detalls del nou tiquet.</p>

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

{{-- Formulari que apunta a la ruta de guardar (tasks.store) --}}
<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-6">
            {{-- Codi del Tiquet (Requisit) --}}
            <div class="mb-3">
                <label for="code" class="form-label">Codi de Tasca</label>
                <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" required>
            </div>
        </div>
        <div class="col-md-6">
            {{-- Data de Previsió (Requisit) --}}
            <div class="mb-3">
                <label for="due_date" class="form-label">Data de Previsió de Finalització</label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}">
            </div>
        </div>
    </div>

    {{-- Descripció (Requisit) --}}
    <div class="mb-3">
        <label for="description" class="form-label">Descripció</label>
        <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
    </div>

    <div class="row">
        <div class="col-md-6">
            {{-- Responsable (Requisit) --}}
            <div class="mb-3">
                <label for="user_id" class="form-label">Responsable</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="" disabled selected>Selecciona un responsable</option>
                    {{-- ASSEGURA'T QUE LA TAULA 'users' NO ESTIGUI BUIDA --}}
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            {{-- Prioritat (Requisit) --}}
            <div class="mb-3">
                <label for="priority_id" class="form-label">Prioritat</label>
                <select class="form-select" id="priority_id" name="priority_id" required>
                    <option value="" disabled selected>Selecciona una prioritat</option>
                    {{-- ASSEGURA'T QUE LA TAULA 'priorities' NO ESTIGUI BUIDA --}}
                    @foreach($priorities as $priority)
                        <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>
                            {{ $priority->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
    <hr>
    <button type="submit" class="btn btn-success me-2">Crear Tasca</button>
    <a href="{{ route('kanban.index') }}" class="btn btn-secondary">Cancel·lar</a>

</form>


</div>
@endsection