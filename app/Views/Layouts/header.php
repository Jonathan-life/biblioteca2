<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Biblioteca</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body { font-family: Arial, sans-serif; margin:20px; }
    table { border-collapse: collapse; width:100%; margin-top:20px; }
    th, td { border:1px solid #ccc; padding:8px; text-align:left; }
    th { background:#f5f5f5; }
    form input, form select, form button { margin:5px 0; padding:6px; width: 100%; }
    form { max-width: 400px; }
    header { display:flex; justify-content:space-between; align-items:center; }
    nav a { margin-left:10px; text-decoration:none; padding:6px 12px; background:#007bff; color:white; border-radius:5px; }
    nav a:hover { background:#0056b3; }
  </style>
</head>
<body>
  <header>
    <h1>📚 Sistema de Biblioteca</h1>
    <nav>
      <a href="<?= base_url('recursos'); ?>">📖 Listar Recursos</a>
      <a href="<?= base_url('recursos/crear'); ?>">➕ Nuevo Recurso</a>
    </nav>
  </header>
  <hr>

