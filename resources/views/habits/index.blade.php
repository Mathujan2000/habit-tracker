<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gewoontetracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4">Mijn Gewoontes</h1>

    <a href="{{ route('habits.create') }}" class="btn btn-primary mb-3">+ Nieuwe gewoonte</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($habits->isEmpty())
        <p class="text-muted">Je hebt nog geen gewoontes toegevoegd.</p>
    @else
        <ul class="list-group">
            @foreach ($habits as $habit)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $habit->name }}</strong><br>
                        <small class="text-muted">{{ $habit->description }}</small>
                    </div>
                    <div>
                        <a href="{{ route('habits.edit', $habit) }}" class="btn btn-sm btn-outline-secondary me-2">Bewerk</a>
                        <form action="{{ route('habits.destroy', $habit) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Verwijder</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
</body>
</html>
