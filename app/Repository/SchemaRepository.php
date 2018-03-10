<?php


namespace MinhD\Repository;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

use MinhD\Exceptions\SchemaInvalid;
use MinhD\Exceptions\SchemaNotFound;

class SchemaRepository
{
    public const MANIFEST_PATH = "manifest.json";

    public function resolve($slug)
    {
        if (!config("schema.$slug")) {
            throw new SchemaNotFound("Schema $slug not found");
        }
        $manifest = Storage::disk('schemas')->get($slug . DIRECTORY_SEPARATOR . self::MANIFEST_PATH);
        $manifest = json_decode($manifest, true);
        $this->verify($manifest, $slug);

        $schema = new Schema($manifest);
        return $schema;
    }

    public function getContent(Schema $schema)
    {
        return Storage::disk('schemas')
            ->get($schema->manifest['slug'] . "/" . $schema->manifest['entry']);
    }

    public function verify($manifest, $slug)
    {
        if (count($manifest) === 0) {
            throw new SchemaInvalid("Schema $slug is invalid");
        }

        // todo entry file exists

        // test various fields here
    }
}