<?php
declare(strict_types=1);

namespace App\GraphQL\Type;
use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;
use Illuminate\Http\UploadedFile;
class Upload extends ScalarType
{

       /**
        * @var UploadType $_instance
        */
       private static $_instance = null;
       /**
        * @var string
        */
       public $name = 'Upload';
       /**
        * @var string
        */
       public $description = 'The `Upload` special type represents a file to be uploaded in the same HTTP request as specified by
    [graphql-multipart-request-spec](https://github.com/jaydenseric/graphql-multipart-request-spec).';
       static public function type()
       {
           if (is_null(self::$_instance)) {
               self::$_instance = new self();
           }
           return self::$_instance;
       }
       /**
        * Serializes an internal value to include in a response.
        *
        * @param mixed $value
        *
        * @return mixed
        */
       public function serialize($value)
       {
           throw new InvariantViolation('`Upload` cannot be serialized');
       }
       /**
        * Parses an externally provided value (query variable) to use as an input
        *
        * @param mixed $value
        *
        * @return mixed
        */
       public function parseValue($value)
       {
           if (!$value instanceof UploadedFile) {
               throw new \UnexpectedValueException('Could not get uploaded file, be sure to conform to GraphQL multipart request specification. Instead got: ' . Utils::printSafe($value));
           }
           return $value;
       }
       /**
        * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input
        *
        * @param \GraphQL\Language\AST\Node $valueNode
        * @param null|array $variables
        *
        * @throws Error
        * @return mixed
        */
       public function parseLiteral($valueNode, array $variables = null)
       {
           throw new Error('`Upload` cannot be hardcoded in query, be sure to conform to GraphQL multipart request specification. Instead got: ' . $valueNode->kind, [$valueNode]);
       }
       protected function __clone()
       {
       }
}
