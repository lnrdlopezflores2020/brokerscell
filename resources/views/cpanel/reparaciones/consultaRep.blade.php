@extends('cpanel/plantilla')
@section('title','dispositivos')
@section('content')
<div class="search-bar" style="margin-top: 100px;">
    <h1>Consulta de Dispositivos en Reparación</h1>
</div>

<div class="search-bar">
    <input type="text" id="searchInput" placeholder="Buscar por cliente, dispositivo o estado...">
    <button onclick="filterTable()">Buscar</button>
</div>

<div class="table-container">
    <div class="background-image">
        <img src="images/SOLUXMOVIL.png" alt="Imagen representativa">
    </div>
    <table id="devicesTable">
        <thead>
        <tr>
            <th>Cliente</th>
            <th>Dispositivo</th>
            <th>Modelo</th>
            <th>Estado</th>
            <th>Fecha de Ingreso</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Juan Pérez</td>
            <td>Teléfono</td>
            <td>Samsung Galaxy S21</td>
            <td>En reparación</td>
            <td>2024-12-18</td>
        </tr>
        <tr>
            <td>María López</td>
            <td>Tableta</td>
            <td>iPad Pro</td>
            <td>Reparado</td>
            <td>2024-12-15</td>
        </tr>
        <tr>
            <td>Carlos García</td>
            <td>Laptop</td>
            <td>Dell Inspiron</td>
            <td>Pendiente</td>
            <td>2024-12-20</td>
        </tr>
        </tbody>
    </table>
</div>
@endsection
