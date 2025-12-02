<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Priority;
use App\Models\User;
use Illuminate\Http\Request;

class KanbanController extends Controller
{

    //Crud: CREATE:

    public function create()
    {
        // Obtenir dades per als camps del formulari
        $priorities = Priority::all();
        $users = User::all();

        // Retorna la vista del formulari
        return view('kanban.create', compact('priorities', 'users'));
    }

    public function store(Request $request)
    {
        // 1. Validació de dades (IMPORTANT)
        $validated = $request->validate([
            'code' => 'required|unique:tasks|max:50', // Codi únic i obligatori
            'description' => 'required',
            'user_id' => 'required|exists:users,id',
            'priority_id' => 'required|exists:priorities,id',
            'due_date' => 'nullable|date',
        ]);

        // 2. Afegir dades per defecte i guardar
        $task = Task::create($validated);
        
        // La tasca es crea automàticament amb status='ToDo' (gràcies a la migració)
        
        // 3. Redireccionar al tauler principal amb un missatge
        return redirect()->route('kanban.index')
            ->with('success', "Tasca '{$task->code}' creada amb èxit i afegida a ToDo.");
    }


    //cRud: READ:
    public function index()
    {
        // 1. Obtenir totes les tasques i carregar les seves relacions
        $tasks = Task::with(['user', 'priority'])->get();

        // 2. Agrupar les tasques per l'estat (status)
        // El resultat serà una Col·lecció amb 3 claus: 'ToDo', 'Doing', 'Done'
        $tasksByStatus = $tasks->groupBy('status');

        // 3. Definir les columnes del tauler (per assegurar l'ordre)
        $statuses = ['ToDo', 'Doing', 'Done'];

        // 4. Retornar la vista i passar-li les dades
        // Si no hi ha tasques per a un estat, el groupBy no el crea. 
        // Per assegurar que la vista sempre tingui les 3 columnes, utilitzem l'Array merge.
        return view('kanban.index', [
            'tasksByStatus' => $tasksByStatus,
            'statuses' => $statuses
        ]);
    }


    //crUd: UPDATE: (Només Estat - Moure a Esquerra/Dreta)
    public function updateStatus(Request $request, Task $task)
    {
    // 1. Validació bàsica
    $request->validate([
        // Assegurem que el nou estat sigui un dels valors permesos pel camp ENUM
        'status' => 'required|in:ToDo,Doing,Done', 
    ]);

    // 2. Actualització de l'estat a la BDD
    $task->status = $request->input('status');
    $task->save();

    // 3. Retornar a la vista principal (el tauler)
    // El missatge de "success" és opcional però útil per a la vista
    return redirect()->route('kanban.index')
        ->with('success', "Estat de la tasca {$task->code} actualitzat a {$task->status}.");
    }

    //crUd: UPDATE: (Edició Completa - Formulari)
    /**
     * Mostra el formulari pre-emplenat per editar una tasca.
     */
    public function edit(Task $task)
    {
        // Necessitem llistes d'usuaris i prioritats per als <select> del formulari
        $priorities = Priority::all();
        $users = User::all();

        // Retorna la vista d'edició, passant la tasca i les llistes
        return view('kanban.edit', compact('task', 'priorities', 'users'));
    }

    /**
     * Processa l'actualització de la tasca al rebre el formulari.
     */
    public function update(Request $request, Task $task)
    {
        // 1. Validació de les dades
        $validated = $request->validate([
            // IMPORTANT: Ignorem l'ID de la tasca actual a la regla 'unique' perquè no falli si el codi no es canvia
            'code' => 'required|max:50|unique:tasks,code,' . $task->id,
            'description' => 'required',
            'user_id' => 'required|exists:users,id',
            'priority_id' => 'required|exists:priorities,id',
            'due_date' => 'nullable|date',
            'status' => 'required|in:ToDo,Doing,Done', // Permetem canviar l'estat
        ]);

        // 2. Actualització de la tasca
        $task->update($validated);

        // 3. Redirecció
        return redirect()->route('kanban.index')->with('success', 'La tasca "' . $task->code . '" ha estat actualitzada correctament.');
    }


    //cruD: DELETE:
    public function destroy(Task $task)
    {
        $taskCode = $task->code;
        $task->delete(); // Elimina la tasca

        // Retornar al tauler
        return redirect()->route('kanban.index')
            ->with('success', "Tasca '{$taskCode}' eliminada permanentment.");
    }

}