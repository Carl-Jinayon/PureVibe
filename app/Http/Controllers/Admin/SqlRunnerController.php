<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SqlRunnerController extends Controller
{
    public function index()
    {
        return view('admin.sql-runner');
    }

    public function execute(Request $request)
    {
        $request->validate([
            'query' => 'required|string'
        ]);

        $query = trim($request->input('query'));
        // Clean trailing semicolon and any trailing whitespace to prevent syntax errors on sub-queries
        $query = preg_replace('/;\s*$/', '', $query);
        $lowerQuery = strtolower($query);

        try {
            // Prevent dangerous destructive queries (Drop/Truncate) just to be safe.
            // We allow UPDATE and DELETE because Phase 3 of the project requires data cleaning.
            if (preg_match('/\b(drop|truncate|alter)\b/i', $query)) {
                return view('admin.sql-runner', [
                    'query' => $query,
                    'sqlError' => 'DANGER: DROP, TRUNCATE, and ALTER commands are disabled in this tool for safety.'
                ]);
            }

            // Handle SELECT, SHOW, DESC queries (Return tabular data)
            if (str_starts_with($lowerQuery, 'select') || str_starts_with($lowerQuery, 'show') || str_starts_with($lowerQuery, 'desc') || str_starts_with($lowerQuery, 'explain')) {
                $results = DB::select($query);
                
                // Convert objects to arrays for easier dynamic blade rendering
                $resultsArray = array_map(function ($item) {
                    return (array) $item;
                }, $results);

                $headers = count($resultsArray) > 0 ? array_keys($resultsArray[0]) : [];

                return view('admin.sql-runner', [
                    'results' => $resultsArray,
                    'headers' => $headers,
                    'query' => $query,
                    'successMsg' => 'Query executed successfully. Returned ' . count($resultsArray) . ' rows.'
                ]);
            } else {
                // Handle UPDATE, DELETE
                $isUpdate = preg_match('/^\s*update\s+([a-zA-Z0-9_]+)\s+set/i', $query, $matchUpdate);
                $isDelete = preg_match('/^\s*delete\s+from\s+([a-zA-Z0-9_]+)/i', $query, $matchDelete);
                
                $tableName = null;
                $whereClause = '';
                
                if ($isUpdate && isset($matchUpdate[1])) {
                    $tableName = str_replace(['`', "'", '"'], '', $matchUpdate[1]);
                    if (preg_match('/where\s+(.*)$/i', $query, $whereMatch)) {
                        $whereClause = trim($whereMatch[1]);
                    }
                } else if ($isDelete && isset($matchDelete[1])) {
                    $tableName = str_replace(['`', "'", '"'], '', $matchDelete[1]);
                    if (preg_match('/where\s+(.*)$/i', $query, $whereMatch)) {
                        $whereClause = trim($whereMatch[1]);
                    }
                }

                $beforeResults = [];
                $afterResults = [];
                $modHeaders = [];

                if ($tableName) {
                    try {
                        // Build the SELECT query — use WHERE clause if present, otherwise show all rows (capped at 50)
                        $selectQuery = $whereClause
                            ? "SELECT * FROM {$tableName} WHERE {$whereClause} LIMIT 50"
                            : "SELECT * FROM {$tableName} LIMIT 50";

                        $beforeData = DB::select($selectQuery);
                        $beforeResults = array_map(function ($item) { return (array) $item; }, $beforeData);
                        if (count($beforeResults) > 0) {
                            $modHeaders = array_keys($beforeResults[0]);
                        }
                    } catch (\Exception $e) {}
                }

                $affectedRows = DB::update($query);
                
                if ($tableName && $isUpdate) {
                    try {
                        // Query the exact updated rows using the IDs from beforeResults to show their new values
                        $ids = array_column($beforeResults, 'id');
                        if (!empty($ids)) {
                            $idList = implode(',', array_map('intval', $ids));
                            $selectQuery = "SELECT * FROM {$tableName} WHERE id IN ({$idList}) LIMIT 50";
                        } else {
                            $selectQuery = $whereClause
                                ? "SELECT * FROM {$tableName} WHERE {$whereClause} LIMIT 50"
                                : "SELECT * FROM {$tableName} LIMIT 50";
                        }

                        $afterData = DB::select($selectQuery);
                        $afterResults = array_map(function ($item) { return (array) $item; }, $afterData);
                        // Ensure headers are set even if beforeResults was empty
                        if (empty($modHeaders) && count($afterResults) > 0) {
                            $modHeaders = array_keys($afterResults[0]);
                        }
                    } catch (\Exception $e) {}
                }

                return view('admin.sql-runner', [
                    'query' => $query,
                    'successMsg' => "Statement executed successfully. Affected {$affectedRows} row(s).",
                    'isModification' => ($isUpdate || $isDelete),
                    'isDelete' => $isDelete,
                    'beforeResults' => $beforeResults,
                    'afterResults' => $afterResults,
                    'modHeaders' => $modHeaders
                ]);
            }

        } catch (\Exception $e) {
            return view('admin.sql-runner', [
                'query' => $query,
                'sqlError' => $e->getMessage()
            ]);
        }
    }
}
