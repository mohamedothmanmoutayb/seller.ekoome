<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Rubix\ML\Classifiers\RandomForest;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Transformers\TextNormalizer;
use Rubix\ML\Transformers\WordCountVectorizer;
use Rubix\ML\Pipeline;
use Illuminate\Support\Facades\Storage;

class IntentDetectionService
{
    protected $pipeline;
    protected $modelPath = 'ml_models/intent_classifier.model';

    public function __construct()
    {
        $this->pipeline = new Pipeline([
            new TextNormalizer(),
            new WordCountVectorizer(1000),
        ], new RandomForest());

        if (Storage::exists($this->modelPath)) {
            $this->pipeline = unserialize(Storage::get($this->modelPath));
        }
    }

    public function train(array $samples, array $labels)
    {
        Log::info("message", ["samples" => $samples, "labels" => $labels]);
        $dataset = new Labeled($samples, $labels);

        $this->pipeline->train($dataset);

        Storage::put($this->modelPath, serialize($this->pipeline));
    }

    public function predict(string $input)
    {
        $dataset = new Unlabeled([$input]);
        return $this->pipeline->predict($dataset)[0];
    }
}
