<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulador Kanban - Projecte DAW</title>

    <style>
        /* --- VARIABLES GLOBALS --- */
        :root {
            --primary-color: #4a90e2; /* Blau Kanban */
            --primary-dark: #3a75b8;
            --background-color: #f7f9fc; /* Fons clar */
            --card-bg-color: #ffffff;
            --text-color: #333;
            --shadow-light: 0 2px 4px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.15);
            --border-radius: 8px;
            /* Fonts del sistema, 100% casolà */
            --font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
        }

        /* --- ESTILS BASE --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
            width: 100%;
        }

        /* --- CAPÇALERA (HEADER) --- */
        .main-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 0;
            box-shadow: var(--shadow-light);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .app-title {
            font-size: 1.8rem;
            font-weight: 800;
        }

        .app-link {
            color: white;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .app-link:hover {
            opacity: 0.8;
        }

        /* --- CONTINGUT PRINCIPAL (MAIN) --- */
        .main-content {
            padding: 30px 0;
            flex-grow: 1;
        }

        /* --- PEU DE PÀGINA (FOOTER) --- */
        .main-footer {
            text-align: center;
            color: #888;
            margin-top: auto;
            padding: 20px 0;
            border-top: 1px solid #ddd;
        }

        .footer-content {
            font-size: 0.9rem;
        }

        /* --- ESTILS DE FORMULARIS GENERALS --- */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-control, .form-select, .form-textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
        }
        
        .form-textarea {
            resize: vertical;
        }

        .form-control:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
        }
        
        .form-card {
            background-color: var(--card-bg-color);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            max-width: 600px;
            margin: 0 auto;
        }

        /* --- BOTONS --- */
        .btn {
            padding: 10px 18px;
            border-radius: var(--border-radius);
            text-decoration: none;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.2s, box-shadow 0.2s, transform 0.1s;
            border: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            box-shadow: var(--shadow-hover);
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
        
        .btn-link {
            background: none;
            border: none;
            color: var(--primary-color);
            text-decoration: underline;
            padding: 0;
            margin-left: 10px;
        }
        
        .btn-link:hover {
            color: var(--primary-dark);
        }

        .btn:active {
            transform: translateY(1px);
        }
        
        .button-row {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
        
        .title-group {
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-color);
        }

        .task-actions {
            display: flex;             /* Activa Flexbox */
            justify-content: space-between; /* Manda uno a cada extremo */
            align-items: center;       /* Los alinea verticalmente al centro */
            width: 100%;               /* Asegura que ocupe todo el ancho disponible */
        }

        /* Opcional: Si quieres que el form no ocupe espacio extra */
        .task-actions form {
            margin: 0;

        }

        /* --- KANBAN BOARD (index.blade.php) --- */

        .kanban-board {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .kanban-column {
            background-color: #e9eef2;
            border-radius: var(--border-radius);
            padding: 15px;
            min-height: 400px;
            box-shadow: 0 3px 9px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column; /* permet separar header i tasks */
        }

        .column-header {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
            color: var(--primary-dark);
        }

        .kanban-tasks {
            flex-grow: 1;          /* ocupa tot l’espai restant */
            min-height: 200px;     /* assegura espai encara que no hi hagi tasques */
            padding-top: 10px;
        }



        .task-card {
            background-color: var(--card-bg-color);
            padding: 15px;
            margin-bottom: 15px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-light);
            transition: all 0.2s ease-in-out;
            border-left: 5px solid #ccc; /* Línia de color per defecte */
        }

        .task-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }
        
        .task-code {
            font-weight: 800;
            color: var(--primary-color);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .task-description {
            margin-bottom: 10px;
            font-size: 1rem;
            font-weight: 600;
        }

        .task-meta {
            font-size: 0.85rem;
            color: #666;
            margin-top: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Estils per a la barra de Prioritat (index.blade.php) */
        .priority-tag {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            line-height: 1;
        }
        
        /* Icones casolanes (utilitzant emojis) */
        .icon-edit::before {
            content: '✏️';
            margin-right: 5px;
        }
        
        .icon-trash::before {
            content: '🗑️'; 
            margin-right: 5px;
        }
        
        .icon-add::before {
            content: '➕'; 
            margin-right: 5px;
        }


        /* --- ACCIONS DE LA TASCA --- */

        .task-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 10px;
        }

        .action-btn {
            background: none;
            border: none;
            color: #888;
            cursor: pointer;
            padding: 5px;
            transition: color 0.2s;
            font-size: 1.1rem;
            line-height: 1;
        }

        .action-btn:hover {
            color: var(--primary-dark);
        }

        .delete-btn {
            color: #dc3545;
        }

        .delete-btn:hover {
            color: #c82333;
        }

        /* --- Responsive per mòbils --- */
        @media (max-width: 768px) {
            .app-title {
                font-size: 1.5rem;
            }
            .main-content {
                padding: 20px 0;
            }
            .kanban-board {
                grid-template-columns: 1fr;
            }
            .kanban-column {
                min-height: auto;
            }
            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container header-content">
            <h1 class="app-title">
                <a href="{{ route('kanban.index') }}" class="app-link">
                    📋 Simulador Kanban
                </a>
            </h1>
        </div>
    </header>

    <main class="main-content">
        @yield('content') 
    </main>
    
    <footer class="main-footer">
        <div class="container footer-content">
            <small>&copy; {{ date('Y') }} Projecte DAW - Jan Fernandez</small>
        </div>
    </footer>
    
</body>
</html>