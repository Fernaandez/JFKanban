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
            <div class="kanban-column" data-status="{{ $status }}">
                <div class="column-header">
                    <span>{{ $status }}</span>
                </div>

                {{-- Contenidor exclusiu per a les targetes --}}
                <div class="kanban-tasks">
                    @forelse($tasksByStatus[$status] ?? collect() as $task)
                        <div class="task-card" 
                             data-id="{{ $task->id }}"
                             style="border-left: 5px solid {{ $task->priority->color_hex ?? '#6C757D' }};">
                            <div class="task-code">{{ $task->code }}</div>
                            <div class="task-description">{{ $task->description }}</div>

                            <div class="task-meta">
                                <span>👤 {{ $task->user->name }}</span>
                                <span>📅 {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Sense data' }}</span>
                            </div>

                            @include('kanban.partials.task_actions', ['task' => $task])
                        </div>
                    @empty

                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Script de SortableJS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.kanban-tasks').forEach(taskContainer => {
        new Sortable(taskContainer, {
            group: 'kanban',
            animation: 150,
            onAdd: async function (evt) {
                let taskId = evt.item.dataset.id;
                let newStatus = evt.to.closest('.kanban-column').dataset.status;

                try {
                    let res = await fetch(`{{ url('/tasks') }}/${taskId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ status: newStatus })
                    });

                    if (!res.ok) {
                        console.error('Error:', await res.text());
                        return;
                    }

                    let data = await res.json();
                    if (data.success) {
                        setTimeout(() => evt.item.style.backgroundColor = '', 1500);
                    }
                } catch (err) {
                    console.error('Catch error:', err);
                }
            }
        });
    });
});
</script>
@endsection