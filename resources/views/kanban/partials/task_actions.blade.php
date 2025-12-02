<div class="d-flex justify-content-between align-items-center mt-2">

    {{-- BOTONS PER MOURE (UPDATE STATUS) --}}
    <div class="move-buttons">
        {{-- Botó 'MOVE LEFT' (a Doing o ToDo) --}}
        @if ($task->status != 'ToDo')
            {{-- Form per canviar a l'estat anterior --}}
            <form action="{{ route('tasks.update_status', $task) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $task->status == 'Doing' ? 'ToDo' : 'Doing' }}">
                <button type="submit" class="btn btn-sm btn-secondary" title="Moure a Esquerra">
                    &#9664; {{-- Fletxa Esquerra --}}
                </button>
            </form>
        @endif

        {{-- Botó 'MOVE RIGHT' (a Doing o Done) --}}
        @if ($task->status != 'Done')
            {{-- Form per canviar a l'estat següent --}}
            <form action="{{ route('tasks.update_status', $task) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $task->status == 'ToDo' ? 'Doing' : 'Done' }}">
                <button type="submit" class="btn btn-sm btn-secondary" title="Moure a Dreta">
                    &#9654; {{-- Fletxa Dreta --}}
                </button>
            </form>
        @endif
    </div>
    <br>
    
    
    {{-- BOTONS D'ACCIÓ (EDITAR I ELIMINAR) --}}
    <div class="action-buttons d-flex align-items-center">
        
        {{-- 1. BOTÓ PER EDITAR (Enllaç GET) - Gris (btn-secondary) --}}
        <form>
        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-secondary me-1" title="Editar Tasca">
            <i class="fas fa-edit"></i> Editar ✏️
        </a>
        </form>
        
        {{-- 2. BOTÓ PER ELIMINAR (Form DELETE) - Vermell (btn-danger) --}}
        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Segur que vols eliminar la tasca {{ $task->code }}?');" class="ms-auto" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar Tasca">
                <i class="fas fa-trash"></i> Eliminar 🗑️
            </button>
        </form>
    </div>
</div>