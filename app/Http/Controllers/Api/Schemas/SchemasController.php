<?php

namespace App\Http\Controllers\Api\Schemas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Response as IlluminateResponse;
class SchemasController extends Controller
{
    /**
     * Display a listing of the classes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $allTable = DB::select('SHOW TABLES');
        $name = 'Tables_in_'.DB::connection()->getDatabaseName();
        foreach($allTable as $table)
        {
            $tables[] = $table->$name;
        }
        if(isset($tables)) {
            for ($i = 0; $i < count($tables); $i++) {
                $table = $tables[$i];
                $results[$i]["className"] = $table;

                $fields = Schema::getColumnListing($table);
                foreach ($fields as $field) {
                    $type = DB::connection()->getDoctrineColumn($table, $field)->getType()->getName();
                    $resultsFields[$field] = compact('type');
                }
                $results[$i]["fields"] = $resultsFields;
            }

            return response()->json(compact('results'));
        }
        response()->json(['message' => 'you do not have any table']);
    }

    /**
     * Store a newly created class in database.
     *
     * EXAMPLE: {"className": "testclass2", "fields":
     * [{"name": "provider", "type": "string"}, {"name": "provider2", "type": "string"}]}
     * @param  \Illuminate\Http\Request  $request
     * @param  $className
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $className)
    {
        $columns = $request['columns'];
        if ($columns) {
            $columns = json_decode($columns);
            $columns = response()->json($columns);
            $classNameField = $columns->getData()->className;

            if ($classNameField != $className) {
                return response()->json([
                    'error_code' => 'Error 404',
                    'error_message' => 'Something went wrong'
                ]);
            }
            if (Schema::hasTable($classNameField)) {
                // class already exist
                $fields = $columns->getData()->fields;
                $schemas = "";
                foreach ($fields as $field) {

                    $columnName = $field->name;
                    $columnType = $field->type;
                    $schemas .= "{$columnName}:{$columnType},";
                }
                $schemas = substr($schemas, 0, -1);
                $fileName = str_replace(':', '_',$schemas);
                $fileName = str_replace(',', '_',$fileName);
                if (str_contains($schemas, ':')) {
                    Artisan::call('make:migration:schema', [
                        "name" => "add_{$fileName}_to_{$classNameField}_table",
                        "--schema" => "{$schemas}",
                        "--model" => "0"]);
                    Artisan::call('migrate');
                    return response()->json(['message' => 'success']);
                }
                return response()->json([
                    'error_code' => 'Error 404',
                    'error_message' => 'Something went wrong'
                ]);
            } else {
                // create new class with columns given
                $fields = $columns->getData()->fields;
                $schemas = "";
                foreach ($fields as $field) {
                    $columnName = $field->name;
                    $columnType = $field->type;

                    if (!Schema::hasColumn($classNameField, $columnName)) {
                        $schemas .= "{$columnName}:{$columnType},";
                    }
                }
                $schemas = substr($schemas, 0, -1);
                if (str_contains($schemas, ':')) {
                    Artisan::call('make:migration:schema', [
                        "name" => "create_{$classNameField}_table",
                        "--schema" => "{$schemas}",
                        "--model" => "0"]);
                    Artisan::call('migrate');

                    return response()->json(['message' => $schemas]);
                }
                return response()->json([
                    'error_code' => 'Error 404',
                    'error_message' => 'Something went wrong'
                ]);
            }
        }

        return response()->json([
            'error_code' => 'Error 404',
            'error_message' => 'Something went wrong'
        ]);
    }

    /**
     * Display the specified class.
     *
     * @param  $className
     * @return \Illuminate\Http\Response
     */
    public function show($className)
    {
        if (!Schema::hasTable($className)) {
            return response()->json(['message' => "you do not have {$className} table"]);
        }
        $fields = Schema::getColumnListing($className);
        foreach ($fields as $field) {
            $type = DB::connection()->getDoctrineColumn($className, $field)->getType()->getName();
            $results["className"] = $className;
            $results["fields"][$field] = compact('type');
        }
        if (isset($results)) {
            return response()->json(compact('results'));
        }
    }


    /**
     * Update the specified class in database.
     *
     * EXAMPLE: {"className": "testclass2", "fields":
     * [{"name": "provider", "type": "string"}, {"name": "provider2", "type": "string"}]}
     * pass delete = 1 param in the request to deleted requested fields
     * @param  \Illuminate\Http\Request  $request
     * @param   $className
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $className)
    {
        $columns = $request['columns'];
        $isDelete = $request['delete'];

        if (!Schema::hasTable($className)) {
            return response()->json(['message' => "you do not have {$className} table"]);
        }
        if ($columns) {
            $columns = json_decode($columns);
            $columns = response()->json($columns);
            $classNameField = $columns->getData()->className;

            if ($classNameField) {
                if ($classNameField != $className) {
                    return response()->json([
                        'error_code' => 'Error 404',
                        'error_message' => 'Something went wrong'
                    ]);
                }
            } else {
                return response()->json([
                    'error_code' => 'Error 404',
                    'error_message' => 'Something went wrong'
                ]);
            }
        } else {
            return response()->json([
                'error_code' => 'Error 404',
                'error_message' => 'Something went wrong'
            ]);
        }

        if ($isDelete == 1) {
            // delete columns
            // class already exist
            $fields = $columns->getData()->fields;
            $schemas = "";
            foreach ($fields as $field) {
                $columnName = $field->name;
                $columnType = $field->type;

                if (Schema::hasColumn($classNameField, $columnName)) {
                    $schemas .= "{$columnName}:{$columnType},";
                }
            }
            $schemas = substr($schemas, 0, -1);
            $fileName = str_replace(':', '_',$schemas);
            $fileName = str_replace(',', '_',$fileName);
            if (str_contains($schemas, ':')) {
                Artisan::call('make:migration:schema', [
                    "name" => "remove_{$fileName}_from_{$classNameField}_table",
                    "--schema" => "{$schemas}",
                    "--model" => "0"]);
                Artisan::call('migrate');
                return response()->json(['message' => 'success']);
            }
            return response()->json([
                'error_code' => 'Error 404',
                'error_message' => 'Something went wrong'
            ]);
        } else {
            // class already exist
            $fields = $columns->getData()->fields;
            $schemas = "";
            foreach ($fields as $field) {
                $columnName = $field->name;
                $columnType = $field->type;

                if (!Schema::hasColumn($classNameField, $columnName)) {
                    $schemas .= "{$columnName}:{$columnType},";
                }
            }
            $schemas = substr($schemas, 0, -1);
            $fileName = str_replace(':', '_',$schemas);
            $fileName = str_replace(',', '_',$fileName);
            if (str_contains($schemas, ':')) {
                Artisan::call('make:migration:schema', [
                    "name" => "add_{$fileName}_to_{$classNameField}_table",
                    "--schema" => "{$schemas}",
                    "--model" => "0"]);
                Artisan::call('migrate');
                return response()->json(['message' => 'success']);
            }
            return response()->json([
                'error_code' => 'Error 404',
                'error_message' => 'Something went wrong'
            ]);
        }
    }

    /**
     * Drop the specified class from database.
     *
     * @param  $className
     * @return \Illuminate\Http\Response
     */
    public function destroy($className)
    {
        if (!Schema::hasTable($className)) {
            return response()->json(['message' => "you do not have {$className} table"]);
        }
        Schema::dropIfExists($className);
        return response()->json(['message' => "{$className} table deleted"]);
    }
}
