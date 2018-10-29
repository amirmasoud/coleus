<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Folklore\GraphQL\GraphQLController;

class UploadAwareGraphQLController extends GraphQLController
{
    public function query(Request $request, $schema = null)
    {
        if (!$schema) {
            $schema = config('graphql.schema');
        }

        $variableInputName = config('graphql.variables_input_name', 'params');
        $query = $request->input('query');
        $params = $request->input($variableInputName);
        $operationName = $request->input('operationName', null);

        if (is_string($params)) {
            $params = json_decode($params, true);
        }

        $context = $this->queryContext($query, $params, $schema);

        return app('graphql')->query($query, $params, [
            'context' => $context,
            'schema' => $schema,
            'operationName' => $operationName
        ]);
    }
}
