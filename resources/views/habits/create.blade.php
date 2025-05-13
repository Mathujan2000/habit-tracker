<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Nieuwe Gewoonte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1>Nieuwe Gewoonte</h1>

    <form method="POST" action="{{ route('habits.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Naam</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Beschrijving</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Opslaan</button>
        <a href="{{ route('habits.index') }}" class="btn btn-secondary">Annuleren</a>
    </form>
</div>
</body>
</html>
