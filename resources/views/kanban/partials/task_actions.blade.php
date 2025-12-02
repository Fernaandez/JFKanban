<div class="d-flex justify-content-between align-items-center mt-2">

    
    
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