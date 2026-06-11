@extends('layouts.admin')

@section('title', 'Academic SQL Runner (DCIT 55A)')

@section('styles')
<style>
    .sql-editor {
        font-family: 'Courier New', Courier, monospace;
        font-size: 1rem;
        background-color: #1e1e1e;
        color: #d4d4d4;
        border-radius: 8px;
        padding: 15px;
        width: 100%;
        min-height: 150px;
        border: 2px solid #333;
        resize: vertical;
    }
    .sql-editor:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    .results-container {
        max-height: 600px;
        overflow: auto;
    }
    .table-results th {
        background-color: #f3f4f6;
        position: sticky;
        top: 0;
        z-index: 1;
        white-space: nowrap;
    }
    .table-results td {
        white-space: nowrap;
    }
    .btn-run {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
        border: none;
        padding: 10px 30px;
        font-weight: bold;
        border-radius: 8px;
        transition: transform 0.2s;
    }
    .btn-run:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="glass-card p-4">
            <h3 class="fw-bold mb-2"><i class="bi bi-terminal text-primary me-2"></i> DCIT 55A: Academic SQL Runner</h3>
            <p class="text-muted mb-0">Execute raw SQL queries to assess data quality, perform data cleaning, and generate analytical insights directly from your system.</p>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="glass-card p-4">
            <form action="{{ route('admin.sql-runner.execute') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="query" class="form-label fw-bold">SQL Query Input</label>
                    <textarea name="query" id="query" class="sql-editor" placeholder="SELECT * FROM products WHERE unit_price IS NULL;" required>{{ $query ?? '' }}</textarea>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted"><i class="bi bi-info-circle"></i> Supports SELECT, UPDATE, DELETE, and JOINs. (DROP/TRUNCATE disabled).</small>
                    </div>
                    <button type="submit" class="btn btn-run"><i class="bi bi-play-fill me-1"></i> Execute Query</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(isset($sqlError))
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-danger shadow-sm border-0 glass-card">
            <h5 class="alert-heading fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> SQL Execution Error</h5>
            <hr>
            <p class="mb-0 font-monospace">{{ $sqlError }}</p>
        </div>
    </div>
</div>
@endif

@if(isset($successMsg))
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-success shadow-sm border-0 glass-card">
            <i class="bi bi-check-circle-fill me-2"></i> {{ $successMsg }}
        </div>
    </div>
</div>
@endif

@if(isset($results) && isset($headers))
<div class="row mb-4">
    <div class="col-12">
        <div class="glass-card p-0">
            <div class="card-header-gradient d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-table me-2"></i> Query Results</h5>
                <span class="badge bg-light text-dark">{{ count($results) }} Rows</span>
            </div>
            
            @if(count($results) > 0)
            <div class="results-container">
                <table class="table table-hover table-bordered table-results mb-0">
                    <thead>
                        <tr>
                            @foreach($headers as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $row)
                            <tr>
                                @foreach($headers as $header)
                                    <td>
                                        @if($row[$header] === null)
                                            <span class="text-danger font-monospace"><i>NULL</i></span>
                                        @else
                                            {{ $row[$header] }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-5 text-center text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                <p class="mb-0">Query executed successfully, but returned 0 rows.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

@endsection
