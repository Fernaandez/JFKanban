@extends('layouts.app')

@section('content')
<div class="container">
    <div class="title-group">
        <h2 class="page-title">Simulador Tauler Kanban</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary icon-add">Nova Tasca</a>
    </div>

    @if(session('success'))
        <div class="form-card" style="margin-bottom: 20px;">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="kanban-board">
        @foreach($statuses as $status)
            <div class="kanban-column">
                <div class="column-header">
                    <span>{{ $status }}</span>
                </div>

                @forelse($tasksByStatus[$status] ?? collect() as $task)
                    <div class="task-card" style="border-left: 5px solid {{ $task->priority->color_hex ?? '#6C757D' }};">
                        <div class="task-code">{{ $task->code }}</div>
                        <div class="task-description">{{ $task->description }}</div>

                        <div class="task-meta">
                            <span>👤 {{ $task->user->name }}</span>
                            <span>📅 {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Sense data' }}</span>
                        </div>

                        @include('kanban.partials.task_actions', ['task' => $task])
                    </div>
                @empty
                    <p class="text-muted">No hi ha tasques en aquesta columna.</p>
                @endforelse
            </div>
        @endforeach
    </div>
</div>
@endsection