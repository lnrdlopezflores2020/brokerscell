@extends('cpanel/plantillaTecnicos') {{-- Reemplaza con el nombre de tu archivo layout principal --}}

@section('title', 'Buscador Técnico')

@section('content')
<div class="container-fluid py-4 h-100 d-flex flex-column">
    <div class="card shadow-sm border-0 rounded-4 bg-body flex-grow-1 overflow-hidden d-flex flex-column">
        
        <div style="height: 6px; background: linear-gradient(90deg, #6f42c1, #0d6efd);"></div>

        <div class="card-header bg-transparent border-bottom pt-4 pb-3 px-4">
            <h4 class="card-title fw-bold text-body m-0">
                <i class="bi bi-google text-primary me-2"></i>Búsqueda Técnica Web
            </h4>
            <p class="text-secondary small mb-0 mt-1">Busca manuales, diagramas, firmware o repuestos directamente en Google.</p>
        </div>

        <div class="card-body p-4 p-md-5 overflow-auto d-flex flex-column">
            
            {{-- Barra de Búsqueda --}}
            <div class="row justify-content-center mb-5">
                <div class="col-md-8">
                    <form id="searchForm" class="d-flex shadow-sm rounded-pill p-1 border bg-body">
                        <input type="text" id="searchInput" class="form-control border-0 bg-transparent shadow-none ms-2" placeholder="Ej. Hard reset Samsung A54, Diagrama esquemático iPhone 11..." required>
                        <button type="submit" class="btn rounded-pill px-4 text-white fw-bold" style="background-color: #6f42c1;">
                            <i class="bi bi-search me-1"></i> Buscar
                        </button>
                    </form>
                </div>
            </div>

            {{-- Contenedor de Resultados --}}
            <div class="row justify-content-center flex-grow-1">
                <div class="col-md-10">
                    
                    {{-- Loader --}}
                    <div id="loader" class="text-center d-none py-5">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-3 text-muted">Buscando resultados...</p>
                    </div>

                    {{-- Lista de Resultados --}}
                    <div id="resultadosContainer">
                        <div class="text-center text-muted py-5" id="estadoVacio">
                            <i class="bi bi-globe2 display-1 opacity-25"></i>
                            <h5 class="mt-3">Realiza una búsqueda para ver los resultados</h5>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('searchForm');
        const searchInput = document.getElementById('searchInput');
        const resultadosContainer = document.getElementById('resultadosContainer');
        const loader = document.getElementById('loader');
        const estadoVacio = document.getElementById('estadoVacio');

        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const query = searchInput.value.trim();
            if(!query) return;

            // Mostrar loader
            estadoVacio?.classList.add('d-none');
            resultadosContainer.innerHTML = '';
            loader.classList.remove('d-none');

            // Prefijo dinámico según el rol (admon o tecnico)
            const prefix = window.location.pathname.split('/')[1]; 

            // Petición a tu propio servidor (Controlador Laravel)
            fetch(`/${prefix}/buscador/buscar?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    loader.classList.add('d-none');
                    
                    if(data.error) {
                        resultadosContainer.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                        return;
                    }

                    if(data.organic_results && data.organic_results.length > 0) {
                        let html = '<p class="text-muted small mb-4">Aproximadamente ' + (data.search_information?.formatted_total_results || 'varios') + ' resultados.</p>';
                        
                        data.organic_results.forEach(result => {
                            html += `
                                <div class="mb-4 pb-3 border-bottom border-secondary-subtle">
                                    <a href="${result.link}" target="_blank" class="text-decoration-none">
                                        <span class="d-block small text-muted text-truncate" style="max-width: 90%;">${result.displayed_link || result.link}</span>
                                        <h5 class="text-primary mb-1 hover-underline" style="color: #0d6efd !important;">${result.title}</h5>
                                    </a>
                                    <p class="text-body mb-0" style="font-size: 0.95rem;">${result.snippet}</p>
                                </div>
                            `;
                        });
                        resultadosContainer.innerHTML = html;
                    } else {
                        resultadosContainer.innerHTML = `
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-search display-4 opacity-25"></i>
                                <h5 class="mt-3">No se encontraron resultados para "${query}"</h5>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    loader.classList.add('d-none');
                    resultadosContainer.innerHTML = `<div class="alert alert-danger">Error de conexión. Intenta de nuevo.</div>`;
                    console.error('Error:', error);
                });
        });
    });
</script>
@endsection